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
            $table->string('describe_project');
            $table->string('name_create');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('status')->default('0');
            $table->integer('privacy')->default('0')->comment('0:Công Khai, 1:Riêng Tư');
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
