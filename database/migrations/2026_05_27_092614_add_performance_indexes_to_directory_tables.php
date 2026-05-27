<?php

declare(strict_types=1);

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
        Schema::table('categories', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order']);
            $table->index(['parent_id', 'is_active']);
        });

        Schema::table('listings', function (Blueprint $table) {
            // Frequently used filters in directory search/listing
            $table->index(['status', 'is_promoted', 'created_at']);
            $table->index(['category_id', 'status', 'is_promoted']);
            $table->index(['user_id', 'status']);
            
            // Full-text index for searching names and descriptions (MySQL 8+)
            $table->fullText(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'sort_order']);
            $table->dropIndex(['parent_id', 'is_active']);
        });

        Schema::table('listings', function (Blueprint $table) {
            $table->dropIndex(['status', 'is_promoted', 'created_at']);
            $table->dropIndex(['category_id', 'status', 'is_promoted']);
            $table->dropIndex(['user_id', 'status']);
            $table->dropFullText(['name', 'description']);
        });
    }
};
