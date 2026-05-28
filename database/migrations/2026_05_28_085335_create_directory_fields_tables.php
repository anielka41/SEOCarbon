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
        Schema::create('directory_fields', function (Blueprint $blueprint): void {
            $blueprint->id();
            $blueprint->uuid('uuid')->unique();
            $blueprint->string('name')->unique();
            $blueprint->string('label');
            $blueprint->string('type'); // text, textarea, number, select, multi_select, checkbox, date, etc.
            $blueprint->string('placeholder')->nullable();
            $blueprint->string('help_text')->nullable();
            $blueprint->json('options')->nullable(); // For select, multi_select, etc.
            $blueprint->json('validation_rules')->nullable();
            $blueprint->boolean('is_required')->default(false);
            $blueprint->boolean('is_searchable')->default(false);
            $blueprint->boolean('is_filterable')->default(false);
            $blueprint->integer('sort_order')->default(0);
            $blueprint->timestamps();
            $blueprint->softDeletes();
        });

        Schema::create('directory_field_values', function (Blueprint $blueprint): void {
            $blueprint->id();
            $blueprint->foreignId('directory_entry_id')->constrained()->cascadeOnDelete();
            $blueprint->foreignId('directory_field_id')->constrained()->cascadeOnDelete();
            $blueprint->text('value')->nullable();
            $blueprint->timestamps();

            $blueprint->unique(['directory_entry_id', 'directory_field_id'], 'entry_field_unique');
        });

        Schema::create('directory_category_field', function (Blueprint $blueprint): void {
            $blueprint->foreignId('directory_category_id')->constrained()->cascadeOnDelete();
            $blueprint->foreignId('directory_field_id')->constrained()->cascadeOnDelete();
            $blueprint->primary(['directory_category_id', 'directory_field_id'], 'cat_field_primary');
        });

        Schema::create('directory_group_field', function (Blueprint $blueprint): void {
            $blueprint->foreignId('directory_group_id')->constrained()->cascadeOnDelete();
            $blueprint->foreignId('directory_field_id')->constrained()->cascadeOnDelete();
            $blueprint->primary(['directory_group_id', 'directory_field_id'], 'group_field_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directory_group_field');
        Schema::dropIfExists('directory_category_field');
        Schema::dropIfExists('directory_field_values');
        Schema::dropIfExists('directory_fields');
    }
};
