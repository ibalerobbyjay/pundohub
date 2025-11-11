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
        $table->string('cause_of_death')->nullable()->after('date_of_death');
        $table->string('other_cause')->nullable()->after('cause_of_death');
        $table->string('location_of_death')->nullable()->after('other_cause');
    });
}

public function down()
{
    Schema::table('death_reports', function (Blueprint $table) {
        $table->dropColumn(['cause_of_death', 'other_cause', 'location_of_death']);
    });
}
};
