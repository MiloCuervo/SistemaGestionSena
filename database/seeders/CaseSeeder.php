<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\cases;
use App\Models\Contact;
use App\Models\OrganizationProcess;
use App\Models\User;

class CaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $case1 = new cases();
        $case1->case_number = '123456';
        $case1->description = 'Description 1';
        $case1->case_evidence = '[]';
        $case1->status = 'in_progress';
        $case1->type = 'request';
        $case1->user_id = 2;
        $case1->contact_id = random_int(1, 7);
        $case1->organization_process_id = random_int(1, 6);
        $case1->save();

        $case2 = new cases();
        $case2->case_number = '234567';
        $case2->description = 'Description 2';
        $case2->case_evidence = '[]';
        $case2->status = 'in_progress';
        $case2->type = 'request';
        $case2->user_id = 2;
        $case2->contact_id = random_int(1, 7);
        $case2->organization_process_id = random_int(1, 6);
        $case2->save();

        $case3 = new cases();
        $case3->case_number = '345678';
        $case3->description = 'Description 3';
        $case3->case_evidence = '[]';
        $case3->status = 'in_progress';
        $case3->type = 'request';
        $case3->user_id = 2;
        $case3->contact_id = random_int(1, 7);
        $case3->organization_process_id = random_int(1, 6);
        $case3->save();

        $case4 = new cases();
        $case4->case_number = '456789';
        $case4->description = 'Description 4';
        $case4->case_evidence = '[]';
        $case4->status = 'in_progress';
        $case4->type = 'request';
        $case4->user_id = 2;
        $case4->contact_id = random_int(1, 7);
        $case4->organization_process_id = random_int(1, 6);
        $case4->save();

        $case5 = new cases();
        $case5->case_number = '567890';
        $case5->description = 'Description 5';
        $case5->case_evidence = '[]';
        $case5->status = 'in_progress';
        $case5->type = 'request';
        $case5->user_id = 2;
        $case5->contact_id = random_int(1, 7);
        $case5->organization_process_id = random_int(1, 6);
        $case5->save();

        $case6 = new cases();
        $case6->case_number = '678901';
        $case6->description = 'Description 6';
        $case6->case_evidence = '[]';
        $case6->status = 'in_progress';
        $case6->type = 'request';
        $case6->user_id = 2;
        $case6->contact_id = random_int(1, 7);
        $case6->organization_process_id = random_int(1, 6);
        $case6->save();
    }
}
