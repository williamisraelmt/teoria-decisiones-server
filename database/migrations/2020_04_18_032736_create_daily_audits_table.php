<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_audits', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('auditor_name');
            $table->string('supervisor_name');
            $table->string('manager_name');
            $table->string('project_name');
            $table->float('requested_equipments');
            $table->float('existing_equipments');
            $table->float('existing_requested_equipments');
            $table->timestamps();
            $table->unsignedBigInteger('report_id');
        });

        Schema::table('daily_audits', function (Blueprint $table) {
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
        Schema::dropIfExists('daily_audits');
    }
}
