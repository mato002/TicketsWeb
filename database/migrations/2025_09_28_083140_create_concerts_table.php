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
        Schema::create('concerts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('artist');
            $table->string('venue');
            $table->text('venue_address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->date('event_date');
            $table->time('event_time');
            $table->integer('duration_minutes')->default(120);
            $table->decimal('base_price', 10, 2);
            $table->integer('total_tickets');
            $table->integer('available_tickets');
            $table->string('image_url')->nullable();
            $table->enum('status', ['draft', 'published', 'cancelled', 'completed'])->default('draft');
            $table->boolean('featured')->default(false);
            $table->json('ticket_categories')->nullable(); // VIP, Regular, Early Bird pricing
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concerts');
    }
};
