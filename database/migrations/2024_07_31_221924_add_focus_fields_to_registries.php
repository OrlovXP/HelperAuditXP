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
            $table->string('focus_region_code')->nullable();
            $table->string('focus_address')->nullable();
            $table->string('focus_dissolution_date')->nullable();
            $table->string('focus_registration_date')->nullable();
            $table->string('focus_head')->nullable();
            $table->string('focus_status')->nullable();
            $table->string('focus_inn')->nullable();
            $table->string('focus_ogrn')->nullable();
            $table->string('focus_subject')->nullable();
            $table->boolean('focus_is_synchronized')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registries', function (Blueprint $table) {
            $table->dropColumn('focus_region_code');
            $table->dropColumn('focus_address');
            $table->dropColumn('focus_dissolution_date');
            $table->dropColumn('focus_registration_date');
            $table->dropColumn('focus_head');
            $table->dropColumn('focus_status');
            $table->dropColumn('focus_inn');
            $table->dropColumn('focus_ogrn');
            $table->dropColumn('focus_subject');
            $table->dropColumn('focus_is_synchronized');
        });
    }
};
