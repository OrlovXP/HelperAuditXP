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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->string('inn'); // ИНН абонента
            $table->string('name')->nullable(); // Название абонента
            $table->string('check')->nullable(); // Счет/Идентификатор платежа
            $table->double('sum')->nullable(); // Сумма по продукту
            $table->double('reward')->nullable(); // Вознаграждение
            $table->string('role')->nullable(); // Роль СЦ
            $table->string('type')->nullable(); // Тип продажи
            $table->string('product')->nullable(); // Продукт
            $table->string('report_date')->nullable(); // Дата отчета
            $table->string('status')->nullable(); // Статус

            $table->integer('crm_deal_id')->nullable(); // CRM id сделки
            $table->integer('crm_company_id')->nullable(); // CRM id компании


            $table->unsignedBigInteger('report_category_id');
            $table->foreign('report_category_id')->references('id')->on('report_categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
