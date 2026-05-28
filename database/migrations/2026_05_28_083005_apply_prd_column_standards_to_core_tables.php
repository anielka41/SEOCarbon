<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = [
            'users',
            'directory_entries',
            'directory_groups',
            'directory_categories',
            'blog_posts',
            'comments',
            'tags',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint): void {
                if (! Schema::hasColumn($blueprint->getTable(), 'uuid')) {
                    $blueprint->uuid('uuid')->nullable()->unique()->after('id');
                }

                if (! Schema::hasColumn($blueprint->getTable(), 'deleted_at')) {
                    $blueprint->softDeletes()->after('updated_at');
                }
            });
        }

        // Populate UUIDs for existing records
        foreach ($tables as $table) {
            DB::table($table)->whereNull('uuid')->get()->each(function ($record) use ($table): void {
                DB::table($table)->where('id', $record->id)->update(['uuid' => (string) Str::uuid()]);
            });

            Schema::table($table, function (Blueprint $blueprint): void {
                $blueprint->uuid('uuid')->nullable(false)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'tags',
            'comments',
            'blog_posts',
            'directory_categories',
            'directory_groups',
            'directory_entries',
            'users',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint): void {
                $blueprint->dropColumn(['uuid', 'deleted_at']);
            });
        }
    }
};
