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
        Schema::table('directory_entries', function (Blueprint $blueprint): void {
            $blueprint->unsignedInteger('views_count')->default(0)->after('status');
            $blueprint->unsignedInteger('clicks_count')->default(0)->after('views_count');
            $blueprint->decimal('ratings_avg', 3, 2)->unsigned()->default(0)->after('clicks_count');
        });

        Schema::table('blog_posts', function (Blueprint $blueprint): void {
            $blueprint->unsignedInteger('views_count')->default(0)->after('status');
            $blueprint->unsignedInteger('comments_count')->default(0)->after('views_count');
            $blueprint->decimal('ratings_avg', 3, 2)->unsigned()->default(0)->after('comments_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $blueprint): void {
            $blueprint->dropColumn(['views_count', 'comments_count', 'ratings_avg']);
        });

        Schema::table('directory_entries', function (Blueprint $blueprint): void {
            $blueprint->dropColumn(['views_count', 'clicks_count', 'ratings_avg']);
        });
    }
};
