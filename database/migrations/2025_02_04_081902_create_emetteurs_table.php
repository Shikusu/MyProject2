<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmetteursTable extends Migration
{
    public function up()
    {
        Schema::create('emetteurs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['radio', 'television']); // Type de l'émetteur
            $table->foreignId('localisation_id')->constrained('localisations')->onDelete('cascade'); // Clé étrangère propre
            $table->date('date_installation');
            $table->date('derniere_maintenance')->nullable(); // Correction du nom pour cohérence
            $table->date('maintenance_prevue')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emetteurs');
    }
}
