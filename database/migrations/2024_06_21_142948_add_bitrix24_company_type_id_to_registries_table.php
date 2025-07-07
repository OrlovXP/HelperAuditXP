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
        Schema::table('registries', function (Blueprint $table) {
            $table->unsignedBigInteger('bitrix24_company_type_id')->nullable();

            $table->foreign('bitrix24_company_type_id')
                ->references('id')
                ->on('bitrix24_company_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registries', function (Blueprint $table) {
            $table->dropForeign(['bitrix24_company_type_id']);
            $table->dropColumn('bitrix24_company_type_id');
        });
    }
};
