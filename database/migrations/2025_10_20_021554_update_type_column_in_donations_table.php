<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Modify the 'type' column to allow Money as well
        DB::statement("
            ALTER TABLE donations 
            MODIFY COLUMN type ENUM('Firewood','Rice','Money') NOT NULL
        ");
    }

    public function down(): void
    {
        // Revert back to original ENUM
        DB::statement("
            ALTER TABLE donations 
            MODIFY COLUMN type ENUM('Firewood','Rice') NOT NULL
        ");
    }
};
