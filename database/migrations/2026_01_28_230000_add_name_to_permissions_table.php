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
        Schema::table('permissions', function (Blueprint $table) {
            if (!Schema::hasColumn('permissions', 'name')) {
                $table->string('name')->nullable()->unique();
            }

            if (!Schema::hasColumn('permissions', 'description')) {
                $table->string('description')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            if (Schema::hasColumn('permissions', 'name')) {
                $table->dropUnique(['name']);
                $table->dropColumn('name');
            }

            if (Schema::hasColumn('permissions', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
