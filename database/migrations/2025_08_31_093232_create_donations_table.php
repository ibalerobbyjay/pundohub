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
    Schema::create('donations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // who donated
        $table->foreignId('bereavement_case_id')->constrained()->onDelete('cascade'); // which case
        $table->enum('type', ['cash', 'rice', 'firewood', 'other']);
        $table->string('amount')->nullable(); // e.g., 500 pesos OR "2 kilos"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
