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
    Schema::table('bereavement_cases', function (Blueprint $table) {
        // Remove old description column
        $table->dropColumn('description');
        
        // Add new structured description fields
        $table->string('description_what')->nullable();
        $table->datetime('description_when')->nullable();
        $table->string('description_where')->nullable();
        $table->string('description_name')->nullable();
        $table->text('description_notes')->nullable();
    });
}

public function down()
{
    Schema::table('bereavement_cases', function (Blueprint $table) {
        $table->text('description')->nullable();
        $table->dropColumn([
            'description_what',
            'description_when', 
            'description_where',
            'description_name',
            'description_notes'
        ]);
    });
}
};
