<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('donations', function (Blueprint $table) {
        // Drop member_id only if it exists
        if (Schema::hasColumn('donations', 'member_id')) {
            $table->dropForeign(['member_id']);
            $table->dropColumn('member_id');
        }

        // Add user_id only if it doesn't already exist
        if (!Schema::hasColumn('donations', 'user_id')) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        }
    });
}


public function down()
{
    Schema::table('donations', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
        $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
    });
}

};
