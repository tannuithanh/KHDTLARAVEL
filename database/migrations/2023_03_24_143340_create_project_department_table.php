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
        Schema::create('project_department', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('department_id');
            $table->foreign('project_id')->references('id')->on('project')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->integer('status')->default('0');
            $table->string('note')->nullable();
            $table->double('completion', 5, 2)->default(0);
            $table->integer('number_of_edits')->default(0);
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
        Schema::dropIfExists('project_department');
    }
};
