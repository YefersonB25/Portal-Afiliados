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
            $table->enum('document_type', ['NIT', 'CC'])->nullable();
            $table->string('number_id', 20)->unique();
            $table->string('name', 190);
            $table->string('phone', 11)->nullable();
            $table->string('photo', 500)->nullable();
            $table->string('photo_id', 500)->nullable();
            $table->enum('status', ['NUEVO', 'CONFIRMADO', 'RECHAZADO', 'ASOCIADO'])->default('NUEVO');
            $table->enum('notifications', ['PUSHER', 'EMAIL', 'TODOS'])->default('PUSHER');
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
