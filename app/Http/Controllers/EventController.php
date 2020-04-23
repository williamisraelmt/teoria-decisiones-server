<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventType;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function create(Request $request)
    {
        $valid = $this->validate($request, [
            "description" => "string",
            "event_id" => "nullable|exists:events,id",
            "event_type" => "nullable|exists:event_types,id",
            "way_it_affects" => "string",
            "reports" => "array|min:1",
            "start_date" => "string",
            "end_date" => "string|nullable"
        ]);
        preg_match("/(.*)[T]/", $valid['start_date'], $start_date_match);
        if ($valid['end_date'] !== null) {
            preg_match("/(.*)[T]/", $valid['end_date'], $end_date_match);
        }
        $event = new Event();
        $event->description = $valid['description'];
        $event->event_id = $valid['event_id'] ?? null;
        $event->event_type_id = $valid['event_type'] ?? null;
        $event->start_date = $start_date_match[1];
        $event->way_it_affects = $valid['way_it_affects'];
        $event->end_date = $valid['end_date'] !== null ? $end_date_match[1] : null;
        $event->save();
        $event->reports()->attach($valid['reports']);
        response()->json(
            [
                "data" => $event
            ]);
    }

    public function getEventTypes()
    {
        return response()->json([
            "data" => EventType::all()
        ]);
    }

    public function getAll()
    {
        return response()->json([
            "data" => Event::all()
        ]);
    }
}
