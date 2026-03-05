<?php

/**
 * Copyright (c) 2025 Matech Technologies. All rights reserved.
 */

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
        Schema::table('bookings', function (Blueprint $table) {
            // Only try to drop foreign key if it exists
            if (Schema::hasColumn('bookings', 'concert_id')) {
                // Remove old columns that don't match model
                $table->dropColumn(['concert_id', 'ticket_quantity', 'ticket_price', 'ticket_categories']);
            }
            
            // Add missing columns that model expects
            if (!Schema::hasColumn('bookings', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Restore old columns
            $table->foreignId('concert_id')->constrained()->onDelete('cascade');
            $table->integer('ticket_quantity');
            $table->decimal('ticket_price', 10, 2);
            $table->json('ticket_categories')->nullable();
            
            // Remove added columns
            $table->dropColumn('payment_method');
        });
    }
};
