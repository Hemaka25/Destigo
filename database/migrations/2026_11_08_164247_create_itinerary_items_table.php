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
    Schema::create('itinerary_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('trip_id')->constrained('trips')->cascadeOnDelete();
        $table->foreignId('destination_id')->nullable()->constrained('destinations')->nullOnDelete();
        $table->foreignId('activity_id')->nullable()->constrained('activities')->nullOnDelete();
        $table->string('item_title');
        $table->date('activity_date');
        $table->time('start_time')->nullable();
        $table->time('end_time')->nullable();
        $table->text('notes')->nullable();
        $table->unsignedInteger('sequence')->default(1);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary_items');
    }
};
