<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
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
        $user->name = "administrador";
        $user->email = "admin@mail.com";
        $user->password = Hash::make('admin-akia'); //bcrypt('admin-akia');
        $user->save();
        // $token = $user->createToken('token-name');
        // // $user->activation_token = "abcd";
        
    }
}
