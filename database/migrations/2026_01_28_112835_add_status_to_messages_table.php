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
        Schema::table('messages', function (Blueprint $table) {
        // On ajoute la colonne 'status' avec 'pending' par défaut
        $table->string('status')->default('pending')->after('content');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('messages', function (Blueprint $table) {
        // Permet de revenir en arrière si besoin
        $table->dropColumn('status');
    });
    }
};
