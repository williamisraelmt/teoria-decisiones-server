<?php

namespace App\Http\Controllers;

use App\DailyOccupancy;
use Illuminate\Http\Request;

class DailyOccupancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $daily_occupancies =$this->validate($request, [
            '*.date' => 'date',
            '*.agent_name' => 'string',
            '*.supervisor_name' => 'string',
            '*.manager_name' => 'string',
            '*.project_name' => 'string',
            '*.handling_time' => 'numeric',
            '*.available_time' => 'numeric',
            '*.after_call_working_time' => 'numeric',
            '*.schedule_start_time' => 'datetime',
            '*.schedule_end_time' => 'datetime'
        ]);
        foreach ($daily_occupancies as $daily_occupancy){
            $new_daily_occupancy = new DailyOccupancy();
            $new_daily_occupancy->date = $daily_occupancy['date'];
            $new_daily_occupancy->agent_name = $daily_occupancy['agent_name'];
            $new_daily_occupancy->supervisor_name = $daily_occupancy['supervisor_name'];
            $new_daily_occupancy->manager_name = $daily_occupancy['manager_name'];
            $new_daily_occupancy->project_name = $daily_occupancy['project_name'];
            $new_daily_occupancy->handling_time = $daily_occupancy['handling_time'];
            $new_daily_occupancy->available_time = $daily_occupancy['available_time'];
            $new_daily_occupancy->after_call_working_time = $daily_occupancy['after_call_working_time'];
            $new_daily_occupancy->schedule_start_time = $daily_occupancy['schedule_start_time'];
            $new_daily_occupancy->schedule_end_time = $daily_occupancy['schedule_end_time'];
            $new_daily_occupancy->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
