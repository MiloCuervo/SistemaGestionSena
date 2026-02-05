<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrganizationProcess;


class OrganizationProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $process1 = new OrganizationProcess();
        $process1->name = 'Talento Humano';
        $process1->description = 'Gestión de Talento Humano';
        $process1->save();

        $process2 = new OrganizationProcess();
        $process2->name = 'Bienestar Social';
        $process2->description = 'Gestión de Bienestar Social';
        $process2->save();

        $process3 = new OrganizationProcess();
        $process3->name = 'Plan de incentivos';
        $process3->description = 'Gestión de Plan de Incentivos';
        $process3->save();

        $process4 = new OrganizationProcess();
        $process4->name = 'Evaluacion EDL';
        $process4->description = 'Gestión de Evaluacion EDL';
        $process4->save();

        $process5 = new OrganizationProcess();
        $process5->name = 'Ropa de trabajo';
        $process5->description = 'Gestión de Ropa de Trabajo';
        $process5->save();  

        $process6 = new OrganizationProcess();
        $process6->name = 'Proceso de encargos';
        $process6->description = 'Gestión de Proceso de Encargos';
        $process6->save(); 
    }
}
