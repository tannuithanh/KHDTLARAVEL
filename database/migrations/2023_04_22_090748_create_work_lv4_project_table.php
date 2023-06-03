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
        Schema::create('work_lv4_project', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_by_project_department_id');
            $table->string('name_work')->nullable();
            $table->string('responsibility')->nullable();
            $table->foreign('work_by_project_department_id')->references('id')->on('work_by_project_department')->onDelete('cascade');
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('work_lv4_project');
    }
};