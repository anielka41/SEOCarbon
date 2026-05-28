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
        Schema::create('posts', function (Blueprint $blueprint): void {
            $blueprint->id();
            $blueprint->foreignId('user_id')->constrained()->cascadeOnDelete();
            $blueprint->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $blueprint->string('title');
            $blueprint->string('slug')->unique();
            $blueprint->text('excerpt')->nullable();
            $blueprint->longText('content');
            $blueprint->string('featured_image')->nullable();
            $blueprint->string('status')->default('draft');
            $blueprint->timestamp('published_at')->nullable();
            $blueprint->timestamps();

            // Performance indexes
            $blueprint->index(['status', 'published_at']);

            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $blueprint->fullText(['title', 'content']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
