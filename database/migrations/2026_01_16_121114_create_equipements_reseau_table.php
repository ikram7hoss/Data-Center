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
    Schema::create('equipements_reseau', function (Blueprint $table) {
        $table->id();

        $table->foreignId('ressource_id')
              ->constrained('ressources')
              ->onDelete('cascade');

        $table->integer('bande_passante'); // Mbps
        $table->string('emplacement');
        $table->string('etat');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipements_reseau');
    }
};
