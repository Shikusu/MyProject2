<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter la migration.
     *
     * @return void
     */
    public function up()
    {
        // Vérifie si la table 'pannes' existe avant d'ajouter la colonne
        if (Schema::hasTable('pannes')) {
            Schema::table('pannes', function (Blueprint $table) {
                $table->boolean('is_declenchee')->default(false); // Ajoute le champ pour savoir si la panne est déclenchée
            });
        } else {
            // Si la table n'existe pas, crée-la (si nécessaire)
            Schema::create('pannes', function (Blueprint $table) {
                $table->id();
                $table->boolean('is_declenchee')->default(false); // Ajoute le champ
                $table->timestamps();
            });
        }
    }

    /**
     * Annuler la migration.
     *
     * @return void
     */
    public function down()
    {
        // Si la table existe, supprime la colonne
        if (Schema::hasTable('pannes')) {
            Schema::table('pannes', function (Blueprint $table) {
                $table->dropColumn('is_declenchee');
            });
        }
    }
};
