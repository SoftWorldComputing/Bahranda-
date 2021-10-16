<?php
namespace App\Classes;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Response\BahrandaResponse;
use Illuminate\Support\Facades\Hash;

class UserProfileClass
{

    use BahrandaResponse;
    public function __construct()
    {
        $this->userRepo = new User;
    }

    public function getUserProfile($user)
    {
        $user = new UserResource($this->userRepo->find($user->id));
        return $this->get("User profile fetched successfully",$user,"user");
    }

    public function updateProfile($user,$first_name,$last_name,$sex,$phone)
    {
        $user->update([
            "first_name" => $first_name,
            "last_name" => $last_name,
            "sex" => $sex,
            "phone" => $phone
        ]);
        $user->userActivities()->create(["remark" => config('activity.users.user_update_profile'),"status" => "completed"]);

        return $this->created("User profile updated successfully","ok","updated");
    }
    

    public function changePassword($user,$old_password,$new_password)
    {
        // check old password
        $check = Hash::check($old_password, $user->password);
        if($check)
        {
            $user->update([
                "password" => Hash::make($new_password)
            ]);
            $user->userActivities()->create(["remark" => config('activity.users.user_change_password'),"status" => "completed"]);

            return $this->created("User password changed successfully","ok","updated");
        }
        return $this->error("Unable to match current password",400);
    }
}