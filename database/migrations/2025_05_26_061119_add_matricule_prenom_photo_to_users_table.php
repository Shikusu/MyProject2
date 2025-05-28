<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('matricule', 15)->unique()->nullable();
            $table->string('prenom', 50)->nullable();
            $table->string('photo')->nullable()->after('matricule');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['matricule', 'prenom', 'photo']);
        });
    }
};

