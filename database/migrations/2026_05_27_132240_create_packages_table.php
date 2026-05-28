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
        Schema::create('packages', function (Blueprint $blueprint): void {
            $blueprint->id();
            $blueprint->string('name');
            $blueprint->string('slug')->unique();
            $blueprint->text('description')->nullable();
            $blueprint->decimal('price', 10, 2)->default(0);
            $blueprint->integer('duration_days')->default(30);

            // Features
            $blueprint->boolean('can_upload_logo')->default(false);
            $blueprint->boolean('can_upload_thumbnail')->default(false);
            $blueprint->boolean('can_add_backlink')->default(false);
            $blueprint->boolean('is_promoted')->default(false);
            $blueprint->integer('max_tags')->default(3);

            $blueprint->boolean('is_active')->default(true);
            $blueprint->integer('sort_order')->default(0);
            $blueprint->timestamps();
        });

        Schema::table('listings', function (Blueprint $blueprint): void {
            $blueprint->foreignId('package_id')->nullable()->after('category_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $blueprint): void {
            $blueprint->dropConstrainedForeignId('package_id');
        });
        Schema::dropIfExists('packages');
    }
};
