<?php

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
            $blueprint->string('meta_title')->nullable()->after('description');
            $blueprint->string('meta_description')->nullable()->after('meta_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $blueprint): void {
            $blueprint->dropColumn(['meta_title', 'meta_description']);
        });
    }
};
