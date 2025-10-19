<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_verification_fields_to_death_reports.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('death_reports', function (Blueprint $table) {
            $table->string('death_certificate')->nullable(); // image path
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('death_reports', function (Blueprint $table) {
            $table->dropColumn(['death_certificate', 'is_verified', 'verified_at']);
        });
    }
};
