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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->string('make');
            $table->string('model');
            $table->integer('year');
            $table->string('type'); // bus, minibus, van, sedan, suv
            $table->integer('capacity');
            $table->decimal('price_per_km', 8, 2);
            $table->string('driver_name');
            $table->string('driver_phone');
            $table->string('driver_license')->nullable();
            $table->boolean('is_available')->default(true);
            $table->text('features')->nullable(); // WiFi, AC, Music System, etc.
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
