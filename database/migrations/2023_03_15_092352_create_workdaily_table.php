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
        Schema::create('workdaily', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workweek_id')->nullable();
            $table->string('categoryDaily');
            $table->string('describeDaily')->nullable();;
            $table->string('responsibility')->nullable();
            $table->string('support')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('workweek_id')->references('id')->on('workweek')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->date('date');
            $table->string('time')->nullable();
            $table->integer('status')->default('0')->comment('0:Chưa cập nhật, 1:đang thực hiện, 2: hoàn thành');
            $table->string('note')->nullable();
            $table->string('inadequacy')->nullable();
            $table->string('propose')->nullable();
            $table->string('Result')->nullable();
            $table->integer('ResultByWookWeek')->nullable();
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
        Schema::dropIfExists('workdaily');
    }
};
