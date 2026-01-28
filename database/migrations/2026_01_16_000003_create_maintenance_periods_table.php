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
        Schema::create('maintenance_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ressource_id')->constrained('ressources')->onDelete('cascade');

            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('reason')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('scheduled'); // scheduled, ongoing, completed, cancelled

            $table->timestamps();

            $table->index('start_date');
            $table->index('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_periods');
    }
};
