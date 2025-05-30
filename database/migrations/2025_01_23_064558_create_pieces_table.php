<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiecesTable extends Migration
{
    public function up()
    {
        Schema::create('pieces', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('type');
            $table->integer('quantite');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pieces');
    }
}
