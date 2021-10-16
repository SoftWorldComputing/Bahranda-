<?php

namespace App\Classes;

use App\Exceptions\CustomValidationFailed;
use App\Exceptions\RecordNotFoundException;
use App\Http\Controllers\Tenants\Tenant;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Bahranda\Enum\ResponseStatus;
use App\Exceptions\ResourceNotFoundException;
use App\Http\Resources\UserResource;
use App\Mail\ForgotPasswordEmail;
use App\Mail\UserPinReg;
use App\Response\BahrandaResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Tenants as Thetenant;
use App\Models\UserVerificationToken;
use App\Models\Wallet;
use Exception;
use Facade\Ignition\Exceptions\UnableToShareErrorException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Newsletter\NewsletterFacade;

class AuthClass
{
    use BahrandaResponse;

    private $userRepo;

    public function __construct()
    {
        $this->userRepo = new User;
        $this->userVerificationToken = new UserVerificationToken;
        $this->walletRepo = new Wallet;
    }

    public function userLogin($email, $password)
    {
        //email and password of the admin
        try {
            if ($token = auth('api')->attempt(['email' => $email, "password" => $password, 'active' => 1])) { //login successful

                $user = User::whereEmail($email)->first();

                if ($user) {
                    if ($user->verified == 0) {
                        return $this->error("User not authorized, please activate your account", 401);
                    }
                }
                $user->userActivities()->create(["remark" => config('activity.users.user_login'), "status" => "completed"]);
                return $this->created("User successfully login", ['user' => new UserResource(auth('api')->user()), 'access_token' => $token], "user_data");
            } else {

                return $this->error("User email or password incorrect", 400);
            }
        } catch (\Exception $e) {
            return $this->error("Unknown error occured", 500);
        }
    }

    public function signUpUser($email, $password, $first_name, $last_name, $sex, $phone)
    {
        //save to db
        $user =  DB::transaction(function () use ($email, $password, $first_name, $last_name, $sex, $phone) {
            $user = $this->userRepo->create([
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email" => $email,
                "password" => Hash::make($password),
                "active" => 1,
                "verified" => 0,
                "profile_created" => 0,
                "sex" => $sex,
                "phone" => $phone
            ]);
            if ($user) {
                //create wallet
                $this->walletRepo->create([
                    "user_id" => $user->id,
                    "balance" => 0,
                    "expected_earning" => 0,
                    "withdrawn" => 0,
                ]);
                //send epin to user
                $pin = rand(100000, 999999);
                $this->userVerificationToken->create([
                    "user_id" => $user->id,
                    "pin" => $pin,
                    "expiry" => Carbon::now()->addMinutes(60)
                ]);

                //create a wallet
                //send pin to email
                //subscribe user
                try {
                    Mail::to($user->email)->send(new UserPinReg($user, $pin));
                } catch (Exception $e) {
                }
                try {

                    NewsletterFacade::subscribe($email, ['FNAME' => $first_name, 'LNAME' => $last_name]);
                } catch (Exception $e) {
                }
            } else {
                return $this->error("User registeration failed", 400);
            }

            return $user;
        });

        return $this->created("User registeration successfull, complete registeration with the pin sent to your mail", $user, "user");
    }


    public function  confirmPin($email, $pin)
    {

        $user = $this->userRepo->whereEmail($email)->first();
        if ($user) {
            $first =   $this->userVerificationToken
                ->where("user_id", $user->id)
                ->where("pin", $pin)
                ->whereUsed(0)
                ->where("expiry", ">=", Carbon::now())->first();

            if ($first) {
                $first->used = 1;
                $first->save();
                $user->verified = true;
                $user->save();

                return $this->created("User activated successfully, You can login now", "true", "activated");
            } else {
                return $this->error("User activation not found", 400);
            }
        } else {
            return $this->error("User activation not found", 400);
        }
    }



    // public function changePassword($user,$current_password,$new_password)
    // {

    //     if(Hash::check($current_password, $user->password))
    //     {
    //         $admin= User::whereEmail($user->email)->whereActive(1)->first();
    //         $admin->password = Hash::make($new_password);
    //         $admin->save();
    //         return $this->updated("Password changed succesfully","true","updated");

    //     }else{
    //         throw new CustomValidationFailed("Invalid current password");
    //     }
    // }

    public function forgotPassword($email)
    {
        //get user as an active user
        $user =  $this->userRepo->whereEmail($email)->where('verified', 1)->first();
        if ($user) {
            $pin = strtolower(Str::random(15));
            $this->userVerificationToken->updateOrCreate(['user_id' => $user->id], [
                "user_id" => $user->id,
                "pin" => $pin,
                "expiry" => Carbon::now()->addMinutes(60),
                "used" => 0
            ]);
            Mail::to($user->email)->send(new  ForgotPasswordEmail($user, $pin));
            $data =  ["email" => $user->email, "pin-sent" => "true"];
            return $this->created("A pin has been sent to your email", $data, "data");
        }
        return $this->error("User email not verified", 400);
    }

    public function checkPin($email, $pin)
    {
        $user =  $this->userRepo->whereEmail($email)->where('verified', 1)->first();
        if ($user) {
            $first =   $this->userVerificationToken
                ->where("user_id", $user->id)
                ->where("pin", $pin)
                ->whereUsed(0)
                ->where("expiry", ">=", Carbon::now())->first();
            if ($first) {
                return $this->created("Corrent pin", "true", "correct");
            }
            return $this->error("Pin not correct", 400);
        } else {
            return $this->error("User activation not found", 400);
        }
    }

    public function changePassword($email, $password, $pin)
    {
        $user =  $this->userRepo->whereEmail($email)->where('verified', 1)->first();
        if ($user) {
            $first =   $this->userVerificationToken
                ->where("user_id", $user->id)
                ->where("pin", $pin)
                ->whereUsed(0)
                ->where("expiry", ">=", Carbon::now())->first();


            if ($first) {
                $first->used = 1;
                $first->save();

                $password = Hash::make($password);
                $user->update(["password" => $password]);

                return $this->created("User password changed succesfully, You can login now", "true", "updated");
            } else {
                return $this->error("User not found", 400);
            }
        } else {
            return $this->error("User not found", 400);
        }
    }
}
