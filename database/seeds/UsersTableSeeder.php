<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Ever Peña";
        $user->email = "ever@mail.com";
        $user->password = bcrypt('ever');
        $user->activation_token = "abcd";
        $user->save();
    }
}
