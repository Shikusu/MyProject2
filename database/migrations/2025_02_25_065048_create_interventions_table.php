<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emetteur_id')->constrained('emetteurs')->onDelete('cascade'); // Lien correct vers emetteurs
            $table->foreignId('piece_id')->nullable()->constrained('pieces')->onDelete('set null'); // Pièce optionnelle
            $table->date('date_panne');
            $table->string('type_alerte');
            $table->text('message')->nullable(); // Autorise le champ message à être vide
            $table->date('date_reparation')->nullable(); // Ajout de la date de réparation
            $table->text('pieces_utilisees')->nullable(); // Pièces utilisées
            $table->text('description_reparation')->nullable(); // Description de la réparation
            $table->enum('etat', ['en attente', 'réparé', 'en cours'])->default('en attente'); // Ajout état de l'intervention
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
