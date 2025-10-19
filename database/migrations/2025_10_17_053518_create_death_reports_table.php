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
       Schema::create('death_reports', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id'); // who reported
    $table->string('name_of_deceased');
    $table->date('date_of_death')->nullable();
    $table->text('notes')->nullable();
    $table->enum('status', ['pending', 'reviewed'])->default('pending'); // admin status
    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('death_reports');
    }
};
