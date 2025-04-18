<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (!Schema::hasColumn('interventions', 'message')) {
            Schema::table('interventions', function (Blueprint $table) {
                $table->text('message')->nullable();
            });
        }
    }

    public function down(): void {
        if (Schema::hasColumn('interventions', 'message')) {
            Schema::table('interventions', function (Blueprint $table) {
                $table->dropColumn('message');
            });
        }
    }

};
