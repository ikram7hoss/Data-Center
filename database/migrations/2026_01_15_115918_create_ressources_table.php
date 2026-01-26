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
    Schema::create('ressources', function (Blueprint $table) {
        $table->id();
        $table->string('name');

        $table->enum('type', [
            'serveur',
            'machine_virtuelle',
            'equipement_reseau',
            'baie_stockage'
        ]);

        $table->enum('status', [
            'disponible',
            'reserve',
            'maintenance'
        ])->default('disponible');

        // statut général (admin seulement)
        $table->boolean('is_active')->default(true);

        $table->foreignId('data_center_id')->nullable()->constrained('data_centers')->onDelete('set null');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ressources');
    }
};
