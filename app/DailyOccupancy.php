<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DailyOccupancy
 *
 * @property int $id
 * @property string $date
 * @property string $agent_name
 * @property string $supervisor_name
 * @property string $manager_name
 * @property string $project_name
 * @property float $handling_time
 * @property float $available_time
 * @property float $after_call_working_time
 * @property float $schedule_start_time
 * @property float $schedule_end_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $report_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereAfterCallWorkingTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereAgentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereAvailableTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereHandlingTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereManagerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereProjectName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereScheduleEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereScheduleStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereSupervisorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $employee_name
 * @property float $taken_calls
 * @property float $auxiliary_time
 * @property float $occupancy
 * @property string $work_start_date
 * @property string|null $work_end_date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereAuxiliaryTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereEmployeeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereOccupancy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereTakenCalls($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereWorkEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereWorkStartDate($value)
 * @property float $talk_time
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereTalkTime($value)
 * @property float $hold_time
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DailyOccupancy whereHoldTime($value)
 */
class DailyOccupancy extends Model
{
    //
}
