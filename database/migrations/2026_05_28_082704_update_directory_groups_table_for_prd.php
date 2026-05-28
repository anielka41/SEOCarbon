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
        Schema::table('directory_groups', function (Blueprint $blueprint): void {
            $blueprint->unsignedInteger('price_net_amount')->default(0)->after('description');
            $blueprint->string('currency', 3)->default('PLN')->after('price_net_amount');
            $blueprint->unsignedInteger('vat_rate')->default(2300)->after('currency'); // Basis points, e.g., 2300 = 23.00%
            $blueprint->boolean('is_paid')->default(false)->after('vat_rate');
            $blueprint->boolean('requires_backlink')->default(false)->after('can_add_backlink');
            $blueprint->boolean('auto_approve')->default(false)->after('requires_backlink');
            $blueprint->unsignedInteger('max_images')->default(1)->after('auto_approve');
            $blueprint->unsignedInteger('max_links')->default(1)->after('max_images');
            $blueprint->integer('sort_boost')->default(0)->after('max_links');

            if (Schema::hasColumn('directory_groups', 'price')) {
                $blueprint->dropColumn('price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('directory_groups', function (Blueprint $blueprint): void {
            $blueprint->decimal('price', 10, 2)->default(0)->after('description');
            $blueprint->dropColumn([
                'price_net_amount',
                'currency',
                'vat_rate',
                'is_paid',
                'requires_backlink',
                'auto_approve',
                'max_images',
                'max_links',
                'sort_boost',
            ]);
        });
    }
};
