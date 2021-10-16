<?php
namespace App\Classes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin;
use App\Models\PasswordReset;
use App\Mail\AdminPasswordReset;
use App\Models\AdminVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Validator;
class AdminClass {

    
    public function loginAdmin($email,$password)
    {
       $authenticated =  Auth::guard('admin')->attempt(['email' => $email, 'password' => $password,"active" => 1,"verified" => 1]);
       if($authenticated){
           //allow login and move user on to the dashboard
           $admin = Admin::find(auth('admin')->user()->id);
           $admin->adminActivities()->create(["narrative" => config('activity.admins.user_login')]);
           return ["status" => "success","message" => "Login Successfull","admin" => auth('admin')->user()];
       }else{
           //
           return ["status" => "error","message" => "Error!, Invalid email or password"];
       }
    }

    public function sendPasswordReset($email)
    {
        //check if email is valid
         $admin_exists = Admin::whereEmail($email)->whereActive(1)->whereVerified(1)->exists();
         if($admin_exists)
         {
             //get activation url
             $admin= Admin::whereEmail($email)->whereActive(1)->whereVerified(1)->first();
             $activation_url = $this->getActivationUrl(Admin::whereEmail($email)->first());
             Mail::to($admin->email)->send(new AdminPasswordReset($admin,$activation_url));
             return ["status" => "success","message" => "Password reset send successfully"];

         }else
         {
             return ["status" => "error","message" => "Email not on the platform"];
         }
    }

    private function getActivationUrl($admin)
    {
            //check usr has a token class or not
            $activation_token = Str::random(30);
            PasswordReset::updateOrCreate([ "email" => $admin->email],
            ["email" => $admin->email,"token" => $activation_token,"expiry" => date('Y-m-d H:m:i',strtotime('tomorrow')),"used" => 0]);
            return route('admin.password.reset',["token" => $activation_token,"email" => $admin->email]);

    }

    public function activateUser($email,$token) 
    {
        $admin_exists = Admin::whereEmail($email)->whereActive(1)->whereVerified(1)->exists();
        if($admin_exists)
        {
            //check token is valid and yet to expire
            $activate_exist = PasswordReset::whereEmail($email)->whereToken($token)->whereUsed(0)->exists();
            if($activate_exist)
            {
                //activation exist
               $password_reset = PasswordReset::whereEmail($email)->first();
               if(Carbon::now()->lessThan(Carbon::parse($password_reset->expiry)))
               {
                    $password_reset->used = 1;
                    $password_reset->save();
                    return ["status" => "success","message" => "User token is correct,Please set a new password","email" => $email];
               }else{
                    //has expired
                    return ["status" => "error","message" => "Token has expired"];

               }
            }else{
                  return ["status" => "error","message" => "Token already used"];

            }
        }else{
            return ["status" => "error","message" => "Invalid token"];

        }
    }

    public function changePassword($email,$new_password)
    {
        $admin_exists = Admin::whereEmail($email)->whereActive(1)->whereVerified(1)->exists();
        if($admin_exists)
        {
            $admin= Admin::whereEmail($email)->whereActive(1)->whereVerified(1)->first();
            $admin->password = bcrypt($new_password);
            $admin->save();
            return ["status" => "success","message" => "Password changed succesfully, You can login now"];

        }else{
            return ["status" => "error","message" => "Unable to change to password, Please try again"];
        }
    }

    public function verifyUser($email,$token)
    {
        $admin_exists = Admin::whereEmail($email)->whereActive(1)->whereVerified(0)->exists();
        if($admin_exists)
        {
            //check token is valid and yet to expire
            $activate_exist = AdminVerification::whereEmail($email)->whereToken($token)->whereUsed(0)->exists();
            if($activate_exist)
            {
                //activation exist
               $activate = AdminVerification::whereEmail($email)->first();
               if(Carbon::now()->lessThan(Carbon::parse($activate->expiry)))
               {
                    $activate->used = 1;
                    $activate->save();
                     $admin = Admin::whereEmail($email)->first();
                     $admin->verified = 1;
                     $admin->save();
                    return ["status" => "success","message" => "User token is correct,Please set a new password","email" => $email];
               }else{
                    //has expired
                    return ["status" => "error","message" => "Token has expired"];

               }
            }else{
                  return ["status" => "error","message" => "Token already used"];

            }
        }else{
            return ["status" => "error","message" => "Invalid token"];

        }
    }

   
}