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
        Schema::create('categories', function (Blueprint $blueprint): void {
            $blueprint->id();
            $blueprint->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $blueprint->string('name');
            $blueprint->string('slug')->unique();
            $blueprint->text('description')->nullable();
            $blueprint->string('icon')->nullable();
            $blueprint->boolean('is_active')->default(true);
            $blueprint->integer('sort_order')->default(0);
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
