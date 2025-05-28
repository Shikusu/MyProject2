<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('emetteurs', function (Blueprint $table) {
        $table->string('reference')->nullable()->after('id');
        // after('id') place la colonne juste après l'id, modifie selon ta préférence
    });
}

public function down()
{
    Schema::table('emetteurs', function (Blueprint $table) {
        $table->dropColumn('reference');
    });
}

};
