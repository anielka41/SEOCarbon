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
        Schema::table('categories', function (Blueprint $blueprint): void {
            $blueprint->string('type')->default('directory')->after('parent_id');
            $blueprint->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $blueprint): void {
            $blueprint->dropIndex(['type']);
            $blueprint->dropColumn('type');
        });
    }
};
