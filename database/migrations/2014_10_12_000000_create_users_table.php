<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_parentesco', 20)->nullable();
            $table->string('photo', 200)->nullable();
            $table->string('name', 190);
            $table->string('identification', 20);
            $table->string('seleccion_nit', 10)->default('false');
            $table->string('identificationPhoto', 200)->nullable();
            $table->string('email', 190)->unique();
            $table->string('telefono', 11)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('estado')->default('1');
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
