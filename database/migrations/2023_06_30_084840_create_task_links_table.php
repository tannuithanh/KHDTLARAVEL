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
        Schema::create('task_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dependent_task_id');
            $table->unsignedBigInteger('related_task_id');
            $table->string('dependent_task_table');
            $table->string('related_task_table');
            $table->string('relationship_type');
            $table->integer('day')->nullable();
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
        Schema::dropIfExists('task_links');
    }
};
