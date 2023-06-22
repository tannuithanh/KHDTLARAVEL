<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectprochild1', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('projectpro_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('projectpro_id')->references('id')->on('projectprofessional')->onDelete('cascade');
            $table->date('startdate');
            $table->date('enddate');
            $table->string('note')->nullable();;
            $table->double('completion', 5, 2)->default(0);
            $table->integer('status')->default(0);
            $table->integer('lock')->default(0);
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
        Schema::dropIfExists('projectprochild1');
    }
};
