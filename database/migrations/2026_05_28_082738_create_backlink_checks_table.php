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
        Schema::create('backlink_checks', function (Blueprint $blueprint): void {
            $blueprint->id();
            $blueprint->uuid('uuid')->unique();
            $blueprint->foreignId('directory_entry_id')->constrained()->cascadeOnDelete();
            $blueprint->string('status'); // e.g., pending, success, failed, error
            $blueprint->timestamp('checked_at')->nullable();
            $blueprint->text('error_message')->nullable();
            $blueprint->string('html_snapshot_path')->nullable();
            $blueprint->timestamps();

            $blueprint->index(['directory_entry_id', 'status']);
            $blueprint->index('checked_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backlink_checks');
    }
};
