<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penalties', function (Blueprint $table) {
            // ✅ Add any columns that might be missing
            if (!Schema::hasColumn('penalties', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            }

            if (!Schema::hasColumn('penalties', 'amount')) {
                $table->decimal('amount', 10, 2);
            }

            if (!Schema::hasColumn('penalties', 'reason')) {
                $table->text('reason');
            }

            if (!Schema::hasColumn('penalties', 'applied_at')) {
                $table->dateTime('applied_at');
            }

            if (!Schema::hasColumn('penalties', 'due_date')) {
                $table->date('due_date')->nullable();
            }

            if (!Schema::hasColumn('penalties', 'paid')) {
                $table->boolean('paid')->default(false);
            }

            if (!Schema::hasColumn('penalties', 'paid_at')) {
                $table->dateTime('paid_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('penalties', function (Blueprint $table) {
            // 🧹 Remove the columns if you rollback
            if (Schema::hasColumn('penalties', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('penalties', 'amount')) $table->dropColumn('amount');
            if (Schema::hasColumn('penalties', 'reason')) $table->dropColumn('reason');
            if (Schema::hasColumn('penalties', 'applied_at')) $table->dropColumn('applied_at');
            if (Schema::hasColumn('penalties', 'due_date')) $table->dropColumn('due_date');
            if (Schema::hasColumn('penalties', 'paid')) $table->dropColumn('paid');
            if (Schema::hasColumn('penalties', 'paid_at')) $table->dropColumn('paid_at');
        });
    }
};
