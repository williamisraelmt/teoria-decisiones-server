<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ReportGoal
 *
 * @property int $id
 * @property float $goal
 * @property string $start_date
 * @property string $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $report_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportGoal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportGoal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportGoal query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportGoal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportGoal whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportGoal whereGoal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportGoal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportGoal whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportGoal whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReportGoal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReportGoal extends Model
{
    //
}
