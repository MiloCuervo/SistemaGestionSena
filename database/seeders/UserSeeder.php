<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $AdminUser = new User();
        $AdminUser->name = 'Admin';
        $AdminUser->second_name = 'Marleny';
        $AdminUser->last_name = 'SENA';
        $AdminUser->email = 'admin@sena.com';
        $AdminUser->password = Hash::make('123Admin');
        $AdminUser->save();

        $User = new User();
        $User->name = 'User';
        $User->second_name = 'Camilo';
        $User->last_name = 'SENA';
        $User->second_last_name = '';
        $User->email = 'user@sena.com';
        $User->password = Hash::make('123User');
        $User->save();


    }
}
