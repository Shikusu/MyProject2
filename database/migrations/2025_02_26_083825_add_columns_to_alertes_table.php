<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAlertesTable extends Migration
{
    public function up()
    {
        Schema::table('alertes', function (Blueprint $table) {
            // Vérifier si les colonnes existent déjà avant de les ajouter
            if (!Schema::hasColumn('alertes', 'emetteur_id')) {
                $table->unsignedBigInteger('emetteur_id');
            }
            if (!Schema::hasColumn('alertes', 'technicien_id')) {
                $table->unsignedBigInteger('technicien_id');
            }
            if (!Schema::hasColumn('alertes', 'date_alerte')) {
                $table->timestamp('date_alerte')->nullable();
            }

            // Ajouter les clés étrangères si nécessaire
            $table->foreign('emetteur_id')->references('id')->on('emetteurs')->onDelete('cascade');
            $table->foreign('technicien_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('alertes', function (Blueprint $table) {
            $table->dropForeign(['emetteur_id']);
            $table->dropForeign(['technicien_id']);
            $table->dropColumn(['emetteur_id', 'technicien_id', 'date_alerte']);
        });
    }
}
