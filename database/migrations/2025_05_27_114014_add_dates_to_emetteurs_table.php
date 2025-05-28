<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
{
    Schema::table('emetteurs', function (Blueprint $table) {
        $table->date('date_entree')->nullable()->after('date_panne');
        $table->date('date_sortie')->nullable()->after('date_entree');
    });
}

public function down()
{
    Schema::table('emetteurs', function (Blueprint $table) {
        $table->dropColumn(['date_entree', 'date_sortie']);
    });
}

};
