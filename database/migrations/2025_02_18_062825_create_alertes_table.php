<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertesTable extends Migration
{
    public function up()
    {
        Schema::create('alertes', function (Blueprint $table) {
            $table->id();              // Clé primaire
            $table->string('typeA');    // Type d'alerte
            $table->timestamps();      // created_at et updated_at
        });
    }


    public function down()
{
    Schema::dropIfExists('alertes');
}
}
