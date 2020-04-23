<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyOccupanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_occupancies', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('employee_name');
            $table->string('supervisor_name');
            $table->string('manager_name');
            $table->string('project_name');
            $table->float('handling_time');
            $table->float('hold_time');
            $table->float('available_time');
            $table->float('talk_time');
            $table->float('taken_calls');
            $table->float('after_call_working_time');
            $table->float('auxiliary_time');
            $table->float('occupancy');
            $table->time('schedule_start_time');
            $table->time('schedule_end_time');
            $table->date("work_start_date");
            $table->date("work_end_date")->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('report_id');
        });

        Schema::table('daily_occupancies', function (Blueprint $table) {
            $table->foreign('report_id')->references('id')->on('reports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_occupancies');
    }
}
