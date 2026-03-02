<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('identification_number');
            $table->string('email')->unique();
            $table->string('phone', 15)->nullable();
            $table->string('position')->nullable();
            $table->timestamps();
        });

        Schema::create('organization_processes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });



        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->text('case_number')->nullable();
            $table->text('description')->nullable();
            $table->json('case_evidence')->nullable();
            $table->enum('status', ['attended','in_progress','not_attended',])->default('in_progress');
            $table->enum('type', ['complaint', 'request', 'right_of_petition', 'tutelage'])->default('request');
            $table->foreignId('user_id')->nullable()->index();
            $table->foreignId('contact_id')->nullable()->index();
            $table->foreignId('organization_process_id')->nullable()->index();
            $table->date('closed_date')->nullable();
            $table->timestamps();
        });

        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->nullable()->index();
            $table->text('description')->nullable();
            $table->json('follow_up_evidence')->nullable();
            $table->unsignedBigInteger('follow_up_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('organizations_processes');    
        
    }
};
