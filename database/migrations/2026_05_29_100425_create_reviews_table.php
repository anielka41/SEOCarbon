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
        Schema::create('reviews', function (Blueprint $blueprint): void {
            $blueprint->id();
            $blueprint->uuid('uuid')->unique();
            $blueprint->morphs('reviewable');
            $blueprint->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $blueprint->string('author_name')->nullable();
            $blueprint->string('author_email')->nullable();
            $blueprint->unsignedTinyInteger('rating')->index();
            $blueprint->text('content')->nullable();
            $blueprint->string('status')->default('pending')->index();
            $blueprint->string('ip_hash')->nullable();
            $blueprint->string('user_agent_hash')->nullable();
            $blueprint->softDeletes();
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
