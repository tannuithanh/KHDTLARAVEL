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
        Schema::create('workmonth', function (Blueprint $table) {
            $table->id();
            $table->date('startMonth');
            $table->date('endMonth');
            $table->string('categoryMonth');
            $table->string('describeMonth')->nullable();
            $table->string('responsibility');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->string('support')->nullable();
            $table->string('note')->nullable();
            $table->integer('status')->default('0');
            $table->string('inadequacy')->nullable();
            $table->string('propose')->nullable();
            $table->string('Result')->nullable();
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
        Schema::dropIfExists('workmonth');
    }
};
