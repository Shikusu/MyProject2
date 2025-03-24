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
                // Ajoute la colonne 'is_declenchee' si elle n'existe pas déjà
                if (!Schema::hasColumn('pannes', 'is_declenchee')) {
                    $table->boolean('is_declenchee')->default(false);
                }
            });
        } else {
            // La table 'pannes' n'existe pas, tu peux l'ignorer ici car elle est déjà créée
            // ou alors la créer si nécessaire (mais normalement tu ne dois pas recréer une table déjà existante)
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
