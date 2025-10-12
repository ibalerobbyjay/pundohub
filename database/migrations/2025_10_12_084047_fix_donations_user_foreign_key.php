<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            // If the old column name is member_id, rename it to user_id
            if (Schema::hasColumn('donations', 'user_id')) {
                $table->renameColumn('member_id', 'user_id');
            }

            // Drop any old foreign keys just in case
            try {
                $table->dropForeign(['member_id']);
            } catch (\Exception $e) {
                // ignore if doesn't exist
            }

            // Add the correct foreign key to users table
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
