<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DailyPayroll
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyPayroll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyPayroll newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyPayroll query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyPayroll whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyPayroll whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyPayroll whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $date
 * @property string $employee_name
 * @property float $success_payrolls
 * @property float $failed_payrolls
 * @property float $failed_success_payrolls
 * @property string $work_start_date
 * @property string|null $work_end_date
 * @property int $report_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyPayroll whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyPayroll whereEmployeeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyPayroll whereFailedPayrolls($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyPayroll whereFailedSuccessPayrolls($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyPayroll whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyPayroll whereSuccessPayrolls($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyPayroll whereWorkEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyPayroll whereWorkStartDate($value)
 */
class DailyPayroll extends Model
{
    //
}
