<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('emetteurs', function (Blueprint $table) {
            $table->string('status')->default('active'); // Vous pouvez définir un statut par défaut
        });
    }

    public function down()
    {
        Schema::table('emetteurs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

};
