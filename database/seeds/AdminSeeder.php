<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Admin::updateOrCreate(["email" => "admin@bahranda.test"],[
                "email" => "admin@bahranda.test",
                "password" => bcrypt("password"),
                "first_name" => "Super",
                "last_name" => "Admin",
                "phone" => "08177171797",
                "image" => "images/avatar",
                "sex" => 1,
                "active" => 1,
                "verified" => 1
        ]);

    }
}
