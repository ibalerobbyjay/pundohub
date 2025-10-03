<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBereavementCasesTable extends Migration
{
    public function up()
    {
        Schema::create('bereavement_cases', function (Blueprint $table) {
            $table->id();

            // Case info
            $table->string('title')->nullable();           // Title (nullable so you don’t hit default value errors)
            $table->text('description')->nullable();       // Optional description/remarks
            $table->date('date_of_death')->nullable();     // Date of death

            // Relationships
            $table->foreignId('member_id')                 // Who the bereavement case is for
                  ->constrained('members')                 // Foreign key to members table
                  ->onDelete('cascade');                   // Delete case if member is deleted

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bereavement_cases');
    }
}
