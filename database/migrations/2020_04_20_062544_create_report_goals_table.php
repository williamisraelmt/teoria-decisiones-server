<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_goals', function (Blueprint $table) {
            $table->id();
            $table->float("goal");
            $table->date("start_date");
            $table->date("end_date");
            $table->timestamps();
            $table->unsignedBigInteger("report_id");
        });

        Schema::table('report_goals', function (Blueprint $table) {
            $table->foreign('report_id')->references("id")->on("reports");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_goals');
    }
}
