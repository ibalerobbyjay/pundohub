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
    Schema::table('monthly_funds', function (Blueprint $table) {
        $table->string('proof_of_payment')->nullable()->after('amount');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthly_funds', function (Blueprint $table) {
            //
        });
    }
};
