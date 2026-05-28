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
        Schema::table('categories', function (Blueprint $blueprint): void {
            $blueprint->index(['is_active', 'sort_order']);
            $blueprint->index(['parent_id', 'is_active']);
        });

        Schema::table('listings', function (Blueprint $blueprint): void {
            // Frequently used filters in directory search/listing
            $blueprint->index(['status', 'is_promoted', 'created_at']);
            $blueprint->index(['category_id', 'status', 'is_promoted']);
            $blueprint->index(['user_id', 'status']);

            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                // Full-text index for searching names and descriptions (MySQL 8+)
                $blueprint->fullText(['name', 'description']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $blueprint): void {
            $blueprint->dropIndex(['is_active', 'sort_order']);
            $blueprint->dropIndex(['parent_id', 'is_active']);
        });

        Schema::table('listings', function (Blueprint $blueprint): void {
            $blueprint->dropIndex(['status', 'is_promoted', 'created_at']);
            $blueprint->dropIndex(['category_id', 'status', 'is_promoted']);
            $blueprint->dropIndex(['user_id', 'status']);

            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $blueprint->dropFullText(['name', 'description']);
            }
        });
    }
};
