<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResolvedToAlertesTable extends Migration
{
    public function up()
    {
        Schema::table('alertes', function (Blueprint $table) {
            $table->boolean('resolved')->default(false);  // Ajout du champ resolved
        });
    }

    public function down()
    {
        Schema::table('alertes', function (Blueprint $table) {
            $table->dropColumn('resolved');
        });
    }
}


