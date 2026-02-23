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
        $AdminUser->name = 'Lilliana';
        $AdminUser->second_name = 'SENA';
        $AdminUser->last_name = 'Administradora';
        $AdminUser->second_last_name = '';
        $AdminUser->email = 'admin@sena.com';
        $AdminUser->password = Hash::make('123Admin');
        $AdminUser->save();

        $User = new User();
        $User->name = 'Marleny';
        $User->second_name = 'SENA';
        $User->last_name = 'Gaviria';
        $User->second_last_name = '';
        $User->email = 'user@sena.com';
        $User->password = Hash::make('123User');
        $User->save();

        $User2 = new User();
        $User2->name = 'Jhonatan';
<<<<<<< HEAD
        $User2->second_name = 'SENA';
        $User2->last_name = 'Carvajal';
        $User2->second_last_name = '';
        $User2->email = 'comisionado@sena.com';
=======
        $User2->second_name = 'David';
        $User2->last_name = 'Carvajal';
        $User2->second_last_name = 'Rios';
        $User2->email = 'comisionado@example.com';
>>>>>>> ade442bc41c81b9cd6a4e5adc441d69ef49ebe12
        $User2->password = Hash::make('123Comisionado');
        $User2->save();

        $User3 = new User();
<<<<<<< HEAD
        $User3->name = 'Camilo';
        $User3->second_name = 'SENA';
        $User3->last_name = 'Cuervo';
        $User3->second_last_name = '';
        $User3->email = 'comisionado2@sena.com';
        $User3->password = Hash::make('123Comisionado');
        $User3->save();

        $User4 = new User();
        $User4->name = 'Jose';
        $User4->second_name = 'SENA';
        $User4->last_name = 'Quintero';
        $User4->second_last_name = '';
        $User4->email = 'comisionado3@sena.com';
        $User4->password = Hash::make('123Comisionado');
=======
        $User3->name = 'Jose';
        $User3->second_name = '';
        $User3->last_name = 'Quintero';
        $User3->second_last_name = '';
        $User3->email = 'comisionado2@sena.com';
        $User3->password = Hash::make('123456');
        $User3->save();

        $User4 = new User();
        $User4->name = 'Marleny';
        $User4->second_name = '';
        $User4->last_name = 'Gaviria';
        $User4->second_last_name = '';
        $User4->email = 'comisionado3@sena.com';
        $User4->password = Hash::make('123456789');
>>>>>>> ade442bc41c81b9cd6a4e5adc441d69ef49ebe12
        $User4->save();
    }
}
