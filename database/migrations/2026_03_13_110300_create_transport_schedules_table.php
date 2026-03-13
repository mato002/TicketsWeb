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
        Schema::create('transport_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->foreignId('pickup_point_id')->constrained()->onDelete('cascade');
            $table->datetime('departure_time');
            $table->datetime('arrival_time');
            $table->decimal('price', 8, 2);
            $table->integer('available_seats');
            $table->integer('booked_seats')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['event_id', 'departure_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_schedules');
    }
};
