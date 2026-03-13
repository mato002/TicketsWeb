<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add transaction_id column to bookings table
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });
    }
};
