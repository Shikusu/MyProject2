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
        $table->unique('reference');
    });
}

public function down()
{
    Schema::table('emetteurs', function (Blueprint $table) {
        $table->dropUnique(['reference']);
    });
}

};
