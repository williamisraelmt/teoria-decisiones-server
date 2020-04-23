<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyPayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_payrolls', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('employee_name');
            $table->float('success_payrolls');
            $table->float('failed_payrolls');
            $table->float('failed_success_payrolls');
            $table->date("work_start_date");
            $table->date("work_end_date")->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('report_id');
        });

        Schema::table('daily_payrolls', function (Blueprint $table) {
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
        Schema::dropIfExists('daily_payrolls');
    }
}
