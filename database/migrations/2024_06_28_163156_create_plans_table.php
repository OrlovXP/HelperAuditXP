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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable(); // Наименование аудиторской организации, Ф.И.О. индивидуального аудитора, аудитора
            $table->string('ornz')->nullable(); // ОРНЗ
            $table->string('verified_period')->nullable(); // Проверяемый период
            $table->date('check_start_dates')->nullable(); // Даты начала проверки
            $table->string('authorized_experts')->nullable(); // Уполномоченные эксперты
            $table->string('review_curator')->nullable(); // Куратор проверки

            $table->foreignId('registry_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
