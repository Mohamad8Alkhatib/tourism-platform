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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('name_en', 200);
            $table->string('name_ar', 200)->nullable();
            $table->text('description_en');
            $table->text('description_ar')->nullable();
            $table->string('location', 500)->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('organizer', 200)->nullable();
            $table->text('ticket_information')->nullable();
            $table->enum('status', [
                'draft', 'submitted', 'under_review', 'published', 'rejected', 'changes_requested',
            ])->default('draft');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->index('city_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
