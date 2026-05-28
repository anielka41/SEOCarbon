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
        Schema::create('invoices', function (Blueprint $blueprint): void {
            $blueprint->id();
            $blueprint->foreignId('user_id')->constrained()->cascadeOnDelete();
            $blueprint->string('number')->unique();
            $blueprint->decimal('amount_net', 15, 2);
            $blueprint->decimal('amount_vat', 15, 2);
            $blueprint->decimal('amount_gross', 15, 2);
            $blueprint->string('currency')->default('PLN');
            $blueprint->string('status')->default('draft'); // draft, issued, confirmed, cancelled

            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
