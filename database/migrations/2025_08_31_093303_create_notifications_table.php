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
   Schema::create('notifications', function (Blueprint $table) {
    $table->uuid('id')->primary();                 // Notification ID (UUID)
    $table->string('type');                        // Notification class (e.g., App\Notifications\NewBereavementCaseNotification)
    $table->morphs('notifiable');                  // notifiable_type + notifiable_id (polymorphic relation)
    $table->text('data');                          // JSON data payload
    $table->timestamp('read_at')->nullable();      // When notification was read
    $table->timestamps();                          // created_at & updated_at
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
