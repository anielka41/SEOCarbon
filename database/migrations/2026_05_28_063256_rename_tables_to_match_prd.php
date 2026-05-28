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
        Schema::rename('listings', 'directory_entries');
        Schema::rename('packages', 'directory_groups');
        Schema::rename('posts', 'blog_posts');
        Schema::rename('categories', 'directory_categories');

        Schema::table('blog_posts', function (Blueprint $blueprint): void {
            $blueprint->string('seo_title')->nullable()->after('meta_title');
            $blueprint->string('seo_description')->nullable()->after('meta_description');
            $blueprint->string('canonical_url')->nullable()->after('seo_description');
        });

        Schema::table('directory_entries', function (Blueprint $blueprint): void {
            $blueprint->string('seo_title')->nullable()->after('meta_title');
            $blueprint->string('seo_description')->nullable()->after('meta_description');
            $blueprint->string('canonical_url')->nullable()->after('seo_description');
        });

        Schema::table('directory_categories', function (Blueprint $blueprint): void {
            $blueprint->string('seo_title')->nullable()->after('meta_title');
            $blueprint->string('seo_description')->nullable()->after('meta_description');
            $blueprint->string('canonical_url')->nullable()->after('seo_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('directory_categories', function (Blueprint $blueprint): void {
            $blueprint->dropColumn(['seo_title', 'seo_description', 'canonical_url']);
        });

        Schema::table('directory_entries', function (Blueprint $blueprint): void {
            $blueprint->dropColumn(['seo_title', 'seo_description', 'canonical_url']);
        });

        Schema::table('blog_posts', function (Blueprint $blueprint): void {
            $blueprint->dropColumn(['seo_title', 'seo_description', 'canonical_url']);
        });

        Schema::rename('directory_categories', 'categories');
        Schema::rename('blog_posts', 'posts');
        Schema::rename('directory_groups', 'packages');
        Schema::rename('directory_entries', 'listings');
    }
};
