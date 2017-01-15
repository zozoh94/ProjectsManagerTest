<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('clientCompanyName');
            $table->string('performerCompanyName');
            $table->timestampTz('startDate');
            $table->timestampTz('endDate');            
            $table->integer('priority')->unsigned();
            $table->text('comment')->null();
            $table->index('name');
            $table->index(['startDate', 'endDate']);
            $table->index('priority');
            $table->integer('leader_id')->unsigned();
            $table->foreign('leader_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['leader_id']);
        });
        Schema::dropIfExists('projects');
    }
}
