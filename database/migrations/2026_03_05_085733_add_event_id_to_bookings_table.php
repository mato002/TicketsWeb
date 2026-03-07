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
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('event_id')->nullable()->after('id');
            $table->dropColumn(['ticket_quantity', 'ticket_price', 'ticket_categories']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeignId('event_id');
            $table->integer('ticket_quantity');
            $table->decimal('ticket_price', 10, 2);
            $table->json('ticket_categories')->nullable();
        });
    }
};
