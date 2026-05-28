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
        Schema::create('listings', function (Blueprint $blueprint): void {
            $blueprint->id();
            $blueprint->foreignId('category_id')->constrained()->cascadeOnDelete();
            $blueprint->foreignId('user_id')->constrained()->cascadeOnDelete();
            $blueprint->string('name');
            $blueprint->string('slug')->unique();
            $blueprint->string('url')->unique();
            $blueprint->text('description');
            $blueprint->longText('content')->nullable();
            $blueprint->string('logo_path')->nullable();
            $blueprint->string('thumbnail_path')->nullable();
            $blueprint->string('contact_email')->nullable();
            $blueprint->string('contact_phone')->nullable();
            $blueprint->string('address')->nullable();
            $blueprint->string('meta_title')->nullable();
            $blueprint->string('meta_description')->nullable();
            $blueprint->string('status')->default('pending');
            $blueprint->boolean('is_promoted')->default(false);
            $blueprint->timestamp('verified_at')->nullable();
            $blueprint->timestamp('expires_at')->nullable();
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
