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
        Schema::create('trip_plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_plan_id')->constrained()->cascadeOnDelete();
            $table->morphs('itemable'); // itemable_type, itemable_id (place/event/tour)
            $table->unsignedInteger('day_number');
            $table->unsignedInteger('sort_order')->default(0);
            $table->time('start_time')->nullable();
            $table->text('notes')->nullable();
            $table->enum('source', ['manual', 'ai'])->default('manual');
            $table->timestamps();

            $table->index('trip_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_plan_items');
    }
};
