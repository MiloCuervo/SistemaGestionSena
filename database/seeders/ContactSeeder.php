<?php

namespace Database\Seeders;
use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contact1 = new Contact();
        $contact1->full_name = 'Carlos Perez';
        $contact1->identification_number = '1023456789';
        $contact1->identification_number = '1023456789';
        $contact1->email = 'carlos.perez@example.com';
        $contact1->phone = '1234567890';
        $contact1->position = 'Empresa XYZ';
        $contact1->save();

        $contact2 = new Contact();
        $contact2->full_name = 'Lucia Gomez';
        $contact2->identification_number = '1098765432';
        $contact2->email = 'lucia.gomez@example.com';
        $contact2->phone = '9876543210';
        $contact2->position = 'TechnoSoft';
        $contact2->save();

        $contact3 = new Contact();
        $contact3->full_name = 'Mateo Rodriguez';
        $contact3->identification_number = '1076543210';
        $contact3->email = 'mateo.rodriguez@example.com';
        $contact3->phone = '3216549870';
        $contact3->position = 'AgroPlus';
        $contact3->save();

        $contact4 = new Contact();
        $contact4->full_name = 'Sofia Martinez';
        $contact4->identification_number = '1067894321';
        $contact4->email = 'sofia.martinez@example.com';
        $contact4->phone = '5551234567';
        $contact4->position = 'NovaLabs';
        $contact4->save();

        $contact5 = new Contact();
        $contact5->full_name = 'Diego Fernandez';
        $contact5->identification_number = '1056789123';
        $contact5->email = 'diego.fernandez@example.com';
        $contact5->phone = '6098475123';
        $contact5->position = 'AlphaConsulting';
        $contact5->save();

        $contact6 = new Contact();
        $contact6->full_name = 'Valentina Ruiz';
        $contact6->identification_number = '1045678912';
        $contact6->email = 'valentina.ruiz@example.com';
        $contact6->phone = '7485963210';
        $contact6->position = 'GreenFields';
        $contact6->save();

        $contact7 = new Contact();
        $contact7->full_name = 'Juan Perez';
        $contact7->identification_number = '1023456789';
        $contact7->email = 'juan.perez@example.com';
        $contact7->phone = '1234567890';
        $contact7->position = 'Empresa XYZ';
        $contact7->save();
    }
}
