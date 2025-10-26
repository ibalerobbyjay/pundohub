<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastDonationDateToUsersTable extends Migration
{
  public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->timestamp('last_donation_date')->nullable();
    });
}


    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_donation_date');
        });
    }
}
