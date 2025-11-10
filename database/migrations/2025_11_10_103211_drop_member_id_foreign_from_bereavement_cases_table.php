<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bereavement_cases', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['member_id']);
            
            // Now drop the column
            $table->dropColumn('member_id');
        });
    }

    public function down(): void
    {
        Schema::table('bereavement_cases', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
