<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortalSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portal_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('val');
            $table->boolean('isEncrypt')->default(0);
            $table->char('type', 20)->default('string');
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
        Schema::dropIfExists('portal_settings');
    }
}
