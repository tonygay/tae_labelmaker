<?php

use AmigosLabels\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array('name' => 'Administrator', 'username' => 'Admin', 'password' => bcrypt('TAEadmin'), 'admin' => true));
    }

}