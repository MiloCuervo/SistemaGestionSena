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
    }
}
