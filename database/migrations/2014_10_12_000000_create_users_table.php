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
            $table->string('email', 190)->unique();
            $table->foreignId('parent_id', 20)->nullable();
            $table->enum('document_type', ['NIT', 'Cedula de Ciudadania'])->nullable();
            $table->string('number_id', 20)->unique();
            $table->string('name', 190);
            $table->string('phone', 11)->nullable();
            $table->string('photo', 500)->nullable();
            $table->string('photo_id', 500)->nullable();
            $table->enum('estado', ['NUEVO','CONFIRMADO','RECHAZADO','ASOCIADO'])->nullable();
            $table->timestamp('email_verified_at')->nullable();
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
