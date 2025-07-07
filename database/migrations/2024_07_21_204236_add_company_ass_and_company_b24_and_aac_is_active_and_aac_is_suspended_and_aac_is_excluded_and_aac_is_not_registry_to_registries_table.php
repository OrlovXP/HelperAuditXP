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
            $table->boolean('company_aac')->default(false); // компания ААС
            $table->boolean('company_b24')->default(false); // компания Б24

            $table->boolean('aac_is_active')->default(false); // действующая
            $table->boolean('aac_is_suspended')->default(false); // приостановлена
            $table->boolean('aac_is_excluded')->default(false); // исключена
            $table->boolean('aac_is_not_registry')->default(false); // нет в реестре
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registries', function (Blueprint $table) {
            $table->dropColumn('company_aac');
            $table->dropColumn('company_b24');

            $table->dropColumn('aac_is_active');
            $table->dropColumn('aac_is_suspended');
            $table->dropColumn('aac_is_excluded');
            $table->dropColumn('aac_is_not_registry');
        });
    }
};
