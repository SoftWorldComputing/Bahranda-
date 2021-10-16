<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeederClass extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::updateOrCreate(["email" => "user@bahranda.test"],[
            "email" => "user@bahranda.test",
            "password" => bcrypt("password"),
            "first_name" => "User",
            "last_name" => "test",
            "phone" => "08177171797",
            "address" => "lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum ",
            "image" => "images/avatar.png",
            "sex" => 1,
            "active" => 1,
            "verified" => 1
       ]);
    }
}
