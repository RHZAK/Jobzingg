<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('country_ID')->unsigned();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->text('description');
            $table->enum('gender',['Male','Female']);
            $table->date('birthday');
            $table->integer('year_first_experience');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('country_ID')->references('id')->on('countries')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
}
