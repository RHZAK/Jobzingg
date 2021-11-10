<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('client_ID')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('post');
            $table->string('email');
            $table->string('phone');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('client_ID')->references('id')->on('clients')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_clients');
    }
}
