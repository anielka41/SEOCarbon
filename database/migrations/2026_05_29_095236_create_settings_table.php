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
        Schema::create('settings', function (Blueprint $blueprint): void {
            $blueprint->id();
            $blueprint->string('key')->unique()->index();
            $blueprint->text('value')->nullable();
            $blueprint->string('type')->default('string');
            $blueprint->string('group')->default('general')->index();
            $blueprint->text('description')->nullable();
            $blueprint->boolean('is_public')->default(false);
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
