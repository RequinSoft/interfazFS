<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        $user = new User();
        $user->name = "admin";
        $user->user = "admin";
        $user->rol = "admin";
        $user->email = "admin@gmail.com";
        $user->password = "54rtr3007";
        $user->active = "1";
        $user->save();
    }
}
