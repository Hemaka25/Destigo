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
    Schema::create('trip_destinations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('trip_id')->constrained('trips')->cascadeOnDelete();
        $table->foreignId('destination_id')->constrained('destinations')->restrictOnDelete();
        $table->date('visit_date')->nullable();
        $table->unsignedInteger('sequence')->default(1);
        $table->timestamps();

        $table->unique(['trip_id', 'destination_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_destinations');
    }
};
