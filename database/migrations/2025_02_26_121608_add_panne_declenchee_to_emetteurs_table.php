<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('emetteurs', function (Blueprint $table) {
            $table->boolean('panne_declenchee')->default(false); // Ajout de la colonne
        });
    }

    public function down()
    {
        Schema::table('emetteurs', function (Blueprint $table) {
            $table->dropColumn('panne_declenchee'); // Suppression de la colonne
        });
    }
};
