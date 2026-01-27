<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('compte_demandes', function (Blueprint $table) {
        $table->id();
        $table->string('nom_complet');
        $table->string('email')->unique();
        $table->string('password');
        $table->string('role');

        // Relation avec l'utilisateur (si nécessaire)
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

        // Relation avec la ressource
        $table->foreignId('ressource_id')->nullable()->constrained('ressources')->onDelete('cascade');

        // UNE SEULE FOIS ICI
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
