<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_item_id')->constrained()->onDelete('cascade');
            $table->string('ticket_number')->unique();
            $table->string('qr_code')->nullable();
            $table->enum('status', ['active', 'used', 'cancelled'])->default('active');
            $table->timestamp('issued_at')->default(now());
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
            
            $table->index(['booking_id', 'status']);
            $table->index('ticket_number');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
