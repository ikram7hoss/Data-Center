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
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ressource_id')->constrained('ressources')->onDelete('cascade');
            $table->foreignId('responsable_id')->nullable()->constrained('users')->onDelete('set null');

            $table->date('periode_start')->nullable();
            $table->date('periode_end')->nullable();

            $table->enum('status', [
                'en_attente',
                'approuvee',
                'refusee',
                'active',
                'terminee',
                'conflit'
            ])->default('en_attente');

            $table->text('justification')->nullable();
            $table->text('raison_refus')->nullable();
            $table->text('notes')->nullable();
            
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('refused_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();

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
