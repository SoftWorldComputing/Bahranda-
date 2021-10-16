<?php
namespace App\Classes;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use App\Models\AdminVerification;
use App\Mail\AdminVerificationMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminMgtClass
{
    public function __construct()
    {
        $this->adminRepo = new Admin;
        $this->roleRepo = new Role;
        $this->adminVerification = new AdminVerification;

    }

    public function getAdminList($keyword=null,$role=null)
    {
         $filter = $this->adminRepo->query();

         if($keyword){
           
            $filter =  $filter->where('email','like','%'.$keyword.'%')
              ->orWhere(function($qx) use ($keyword) {
                $name  = explode(" ",$keyword);
                if(isset($name[1])){
                    $qx->where('first_name','like','%'.$name[0].'%')
                    ->orWhere('last_name','like','%'.$name[1].'%')
                    ->orWhere('last_name','like','%'.$name[0].'%')
                    ->orWhere('first_name','like','%'.$name[1].'%');
                }else{
                    $qx->where('first_name','like','%'.$keyword.'%')
                    ->orWhere('last_name','like','%'.$keyword.'%');
                }
               
              
            });
                        
        }
         if($role)
         {
             $filter = $filter->whereHas("roles",function($q) use($role){$q->where("id",$role);});
         }
        
         //get count
         $filterclone = clone $filter;
         $count = $filterclone->count();
         
         $admins = $filter->paginate(10);
         return ['status' => "success","message" => "Fetched succesfully","data" => ["admins" => $admins,"count" => $count,"roles_count" => $this->roleRepo->count(),"roles" => Role::all()]];
    }

    public function getAdminDetails($admin)
    {
        $admin =  $this->adminRepo->whereId($admin)->first();
        if($admin)
        {
            return ["status" => "success","message" => "Admin details fetched successfully","admin" => $admin,"roles" => Role::all()];
        }else{
            return ["status" => "error","message" => "Error fetching admin"];
        }
    }

    public function getRoles()
    {
        return  $this->roleRepo->all();

    }

    public function createNewAdmin($admin,$email,$first_name,$last_name,$phone,$sex,$role)
    {
        $password  = bcrypt(Str::random(10));
        $admin =  $this->adminRepo->create(["first_name" => $first_name,"last_name" => $last_name,"phone" => $phone,"sex" => $sex,"active" => 1,"email" => $email ,"password" => $password,"verified" => 0,"image" => 'images/avatar.png']);
        if($admin)
        {
            //register into activation 
            $token = Str::random(30);
            $this->adminVerification->create(["email" => $admin->email,"token" => $token,"expiry" => date('Y-m-d H:m:i',strtotime('tomorrow')),"used" => 0]);
            $activation_route = route('admin.verification.view',['email' => $email,"token" => $token]);
            $role = $this->roleRepo->whereId($role)->first();
            $admin->assignRole($role);
            //
            // $admin->adminActivities()->create(["narrative" => config('activity.admins.user_login')]);
            Mail::to($admin->email)->send(new AdminVerificationMail($admin,$activation_route));
            return ["status" => "success","message" => "Admin created successfully"];
            
        }else{
            return ["status" => "error","message" => "Unable to create admin"];
        }

    }

    public function updateAdmin($admin,$admin_id,$first_name,$last_name,$phone,$sex,$role,$status)
    {
        $admin =  $this->adminRepo->whereId($admin_id)->first();
        if($admin)
        {
            $admin->update(['first_name' => $first_name,'last_name' => $last_name,'phone' => $phone,'sex' => $sex,"active" => $status]);
            $role = $this->roleRepo->whereId($role)->first();
            $admin->syncRoles($role);
            return ["status" => "success","message" => "Admin Updated successfully"];
        }else{
           
            return ["status" => "error","message" => "Admin cannot be updated"];
        }
    }

    public function updtaeAdminProfileImage($admin,$profile_image)
    {
        $admin->update(["image" => $profile_image]);
        $admin->save();
        return ["status" => "success","message" => "Admin Profile Image Updated successfully"];

    }

    public function removeAdmin($theadmin,$admin)
    {
        $admin->delete();
        return ["status" => "success","message" => "Admin deleted succesfully"];

    }

    public function adminChangePassword($admin,$old_password,$new_password)
    {
            if(Hash::check($old_password, $admin->password))
            {
                $admin->password = Hash::make($new_password);
                $admin->save();

                return ["status" => "success","message" => "Password changed succesfully"];

            }

            return ["status" => "error","message" => "Incorrect old password"];


    }
}