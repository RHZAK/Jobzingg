<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('client_ID')->unsigned();
            $table->uuid('contact_clients_ID')->unsigned();
            $table->string('title');
            $table->text('headcount');
            $table->text('address');
            $table->date('dead_line');
            $table->string('tgm');
            $table->text('description');
            $table->enum('contract_type',['FullTime','PartTime','FreeLance','Temporary']);
            $table->enum('location',['Remote','On-Site']);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('client_ID')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('contact_clients_ID')->references('id')->on('contact_clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
