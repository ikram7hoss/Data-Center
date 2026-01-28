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
        Schema::table('ressources', function (Blueprint $table) {
            if (!Schema::hasColumn('ressources', 'location')) {
                $table->string('location')->nullable();
            }
            if (!Schema::hasColumn('ressources', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('ressources', 'os')) {
                // Controller tried to update 'os' on resource too, checking if it was intended there or on child
                // Usually OS is on server/vm, but let's check what the update call did.
                // Step 190: $resource->update(['os', ...])
                // So yes, controller expects OS on generic resource too?
                // Actually step 190 server update ALSO has OS. 
                // Let's add it to verify, or we fix controller.
                // Fixing data model is safer if requirements are vague.
                $table->string('os')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ressources', function (Blueprint $table) {
            $table->dropColumn(['location', 'description', 'os']);
        });
    }
};
