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
        Schema::create('machines_virtuelles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ressource_id')
                  ->constrained('ressources')
                  ->onDelete('cascade');

            $table->integer('cpu');
            $table->integer('ram'); // GB
            $table->integer('stockage'); // GB
            $table->string('os');
            $table->integer('bande_passante'); // Mbps
            $table->string('etat');
            $table->string('hyperviseur')->nullable();
            $table->string('adresse_ip')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines_virtuelles');
    }
};
