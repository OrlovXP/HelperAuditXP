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
        Schema::create('report_categories', function (Blueprint $table) {
            $table->id();
            $table->string('report_date');
            $table->double('total_sum')->nullable();
            $table->double('total_reward')->nullable();
            $table->integer('total_deals')->nullable();
            $table->integer('total_l_deals')->nullable();
            $table->integer('total_s_deals')->nullable();
            $table->integer('total_d_deals')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_categories');
    }
};
