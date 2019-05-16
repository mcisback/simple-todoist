<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Define and create table tasks with all columns
         */
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('task');
            $table->boolean('completed')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        /**
         * Adds a foreign key user_id
         * that references user.id column
         * must be the same type as user.id (unsigned big integer)
         * If user is deleted, every task is also deleted
         * due to 'on delete cascade'
         */
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
