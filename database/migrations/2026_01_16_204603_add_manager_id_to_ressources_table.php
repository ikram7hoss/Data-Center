<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('ressources', function (Blueprint $table) {
        // Ajoute la colonne manager_id
        $table->unsignedBigInteger('manager_id')->nullable()->after('id');
        
        // Optionnel : si tu as une table users, tu peux lier la clé étrangère
        // $table->foreign('manager_id')->references('id')->on('users');
    });
}

public function down()
{
    Schema::table('ressources', function (Blueprint $table) {
        $table->dropColumn('manager_id');
    });
}
};
