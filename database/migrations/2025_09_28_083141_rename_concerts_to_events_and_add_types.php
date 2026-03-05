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
        // Rename the table
        Schema::rename('concerts', 'events');

        // Add the event_type column
        Schema::table('events', function (Blueprint $table) {
            $table->enum('event_type', [
                'music',
                'sports',
                'comedy',
                'car_show',
                'travel',
                'hiking',
                'art',
                'gallery',
                'festival',
                'theater',
                'conference',
                'workshop',
                'other'
            ])->default('music')->after('description');

            // Rename artist to organizer/performer for broader use
            $table->renameColumn('artist', 'organizer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->renameColumn('organizer', 'artist');
            $table->dropColumn('event_type');
        });

        Schema::rename('events', 'concerts');
    }
};
