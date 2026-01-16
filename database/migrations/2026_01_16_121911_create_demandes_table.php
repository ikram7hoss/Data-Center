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
    Schema::create('demandes', function (Blueprint $table) {
        $table->id(); // id demande
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('ressource_id')->constrained('ressources')->onDelete('cascade');

        $table->date('periode_start')->nullable();
        $table->date('periode_end')->nullable();

        $table->text('justification')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
