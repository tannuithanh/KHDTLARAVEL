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
        Schema::create('workweek', function (Blueprint $table) {
            $table->id();
            $table->string('categoryWeek');
            $table->string('describeWeek');
            $table->string('responsibility')->nullable();
            $table->string('support')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->date('startdate');
            $table->date('enddate');
            $table->string('note')->nullable();
            $table->integer('status')->default('0')->comment('0:Chưa báo cáo, 1:Đã báo cáo');
            $table->string('inadequacy')->nullable()->comment('Cập nhật khi status = 1');
            $table->string('propose')->nullable()->comment('Cập nhật khi status = 1');
            $table->integer('Result')->comment('0:Chưa báo cáo, 1:Đã báo cáo')->nullable();
            $table->string('fileupload')->nullable()->comment('Cập nhật khi status = 1');
            $table->integer('idreason')->default('0')->comment('0:chưa nêu lý do, 1:Đã nêu lý do')->nullable();
            $table->string('reason')->nullable();
            $table->string('monday')->nullable();
            $table->string('tuesday')->nullable();
            $table->string('wednesday')->nullable();
            $table->string('thursday')->nullable();
            $table->string('friday')->nullable();
            $table->string('saturday')->nullable();
            $table->string('sunday')->nullable();
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
        Schema::dropIfExists('workweek');
    }
};
