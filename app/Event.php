<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Event
 *
 * @property int $id
 * @property string $description
 * @property string $way_it_affects
 * @property string $start_date
 * @property string|null $end_date
 * @property int|null $event_id
 * @property int $report_id
 * @property int $event_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Event[] $event
 * @property-read int|null $event_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Report[] $eventReport
 * @property-read int|null $event_report_count
 * @property-read \App\EventType $eventType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Event[] $events
 * @property-read int|null $events_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Report[] $reports
 * @property-read int|null $reports_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereEventTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereWayItAffects($value)
 */
class Event extends Model
{
    public function events(){
        return $this->hasMany(Event::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function eventType(){
        return $this->belongsTo(EventType::class);
    }

    public function reports(){
        return $this->belongsToMany(Report::class, "event_reports");
    }
}
