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
        Schema::create('registries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ornz')->nullable();
            $table->string('ogrn')->nullable();
            $table->string('subject')->nullable();
            $table->string('basic_inn')->nullable();
            $table->string('basic_date_entry_into_register')->nullable();
            $table->string('contacts_email')->nullable();
            $table->string('contacts_address_executive_body')->nullable();
            $table->string('contacts_site')->nullable();
            $table->string('employees_count')->nullable();
            $table->string('disciplinary_type_violation')->nullable();
            $table->string('disciplinary_disciplinary_measures')->nullable();
            $table->string('disciplinary_body_that_made_decision')->nullable();
            $table->string('disciplinary_membership_suspension_period')->nullable();
            $table->string('disciplinary_date_which_membership_was_reinstated')->nullable();
            $table->string('disciplinary_maturity_date_measure')->nullable();
            $table->string('controls_job_title')->nullable();
            $table->string('controls_surname')->nullable();
            $table->string('controls_name')->nullable();
            $table->string('controls_family')->nullable();
            $table->string('controls_ornz')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registries');
    }
};
