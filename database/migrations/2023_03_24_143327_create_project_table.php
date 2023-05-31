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
        Schema::create('project', function (Blueprint $table) {
            $table->id();
            $table->string('name_project');
            $table->string('name_create');
            $table->unsignedBigInteger('car_brands_id');
            $table->foreign('car_brands_id')->references('id')->on('car_brands')->onDelete('cascade');
            $table->unsignedBigInteger('car_brands_child_id')->nullable();
            $table->foreign('car_brands_child_id')->references('id')->on('car_brands_child')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('status')->default('0');
            $table->integer('lock')->default('0');
            $table->string('note')->nullable();
            $table->double('completion', 5, 2)->default(0);
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
        Schema::dropIfExists('project');
    }
};
