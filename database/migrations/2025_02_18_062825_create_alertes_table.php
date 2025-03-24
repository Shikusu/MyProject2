<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertesTable extends Migration
{
    public function up()
    {
        Schema::create('alertes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emetteur_id')->constrained('emetteurs')->onDelete('cascade');
            $table->foreignId('technicien_id')->constrained('users')->onDelete('cascade');
            $table->string('type');
            $table->text('message');
            $table->boolean('resolue')->default(false);
            $table->boolean('is_read')->default(false); // Ajouté
            $table->timestamp('date_alerte')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alertes');
    }
}
