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
        Schema::table('death_reports', function (Blueprint $table) {
            // Add is_verified if it doesn't exist
            if (!Schema::hasColumn('death_reports', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('death_certificate');
            }
            
            // Add verified_by if it doesn't exist
            if (!Schema::hasColumn('death_reports', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()->after('is_verified')->constrained('users')->onDelete('set null');
            }
            
            // Add verified_at if it doesn't exist
            if (!Schema::hasColumn('death_reports', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
            
            // Add cause_of_death if it doesn't exist
            if (!Schema::hasColumn('death_reports', 'cause_of_death')) {
                $table->text('cause_of_death')->nullable()->after('date_of_death');
            }
            
            // Add location_of_death if it doesn't exist
            if (!Schema::hasColumn('death_reports', 'location_of_death')) {
                $table->string('location_of_death')->nullable()->after('cause_of_death');
            }
            
            // Make notes nullable if it exists
            if (Schema::hasColumn('death_reports', 'notes')) {
                $table->text('notes')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('death_reports', function (Blueprint $table) {
            // Remove columns only if they exist
            if (Schema::hasColumn('death_reports', 'verified_by')) {
                $table->dropForeign(['verified_by']);
            }
            
            $columnsToDrop = ['is_verified', 'verified_by', 'verified_at', 'cause_of_death', 'location_of_death'];
            
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('death_reports', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};