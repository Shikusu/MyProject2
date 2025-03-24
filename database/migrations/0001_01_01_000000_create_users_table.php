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
        // Table des utilisateurs
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->string('name'); // Nom de l'utilisateur
            $table->string('email')->unique(); // Email unique
            $table->timestamp('email_verified_at')->nullable(); // Date de vérification d'email
            $table->string('password'); // Mot de passe
            $table->enum('role', ['admin', 'technicien'])->default('technicien'); // Rôle : admin ou technicien
            $table->rememberToken(); // Jeton de session "Remember Me"
            $table->timestamps(); // Dates de création et de mise à jour
        });

        // Table des tokens pour réinitialisation de mot de passe
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email associé au token
            $table->string('token'); // Token de réinitialisation
            $table->timestamp('created_at')->nullable(); // Date de création
        });

        // Table des sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Identifiant unique de session
            $table->foreignId('user_id')->nullable()->index(); // Référence vers un utilisateur
            $table->string('ip_address', 45)->nullable(); // Adresse IP
            $table->text('user_agent')->nullable(); // Informations sur le navigateur/agent
            $table->longText('payload'); // Données de la session
            $table->integer('last_activity')->index(); // Dernière activité
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Suppression des tables dans l'ordre inverse de leur création
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
