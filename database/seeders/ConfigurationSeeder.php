<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserConfiguration;
use App\Models\Role;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = new Role();
        $adminRole->name = 'admin';
        $adminRole->save();

        $userRole = new Role();
        $userRole->name = 'user';
        $userRole->save();

        $adminConfig = new UserConfiguration();
        $adminConfig->user_id = 1;
        $adminConfig->role_id = $adminRole->id;
        $adminConfig->dark_mode = true;
        $adminConfig->report_frequency = 'daily';
        $adminConfig->save();


        $userConfig = new UserConfiguration();
        $userConfig->user_id = 2;
        $userConfig->role_id = $userRole->id;
        $userConfig->dark_mode = false;
        $userConfig->report_frequency = 'weekly';
        $userConfig->save();

        $userConfig1 = new UserConfiguration();
        $userConfig1->user_id = 3;
        $userConfig1->role_id = $userRole->id;
        $userConfig1->dark_mode = false;
        $userConfig1->report_frequency = 'weekly';
        $userConfig1->save();

        $userConfig2 = new UserConfiguration();
        $userConfig2->user_id = 4;
        $userConfig2->role_id = $userRole->id;
        $userConfig2->dark_mode = false;
        $userConfig2->report_frequency = 'weekly';
        $userConfig2->save();

        $userConfig3 = new UserConfiguration();
        $userConfig3->user_id = 5;
        $userConfig3->role_id = $userRole->id;
        $userConfig3->dark_mode = false;
        $userConfig3->report_frequency = 'weekly';
        $userConfig3->save();
    }
}
