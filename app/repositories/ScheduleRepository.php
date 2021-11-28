<?php

namespace App\repositories;

use App\Models\companyInfo;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class ScheduleRepository
{
    /* query for store a new schedule */
    public function store($data)
    {
        $schedule = Schedule::create($data);

        return $schedule;
    }

    /* query for update a schedule */
    public function update($id, $data)
    {
        $schedule = Schedule::find($id);
        $schedule->update($data);

        return $schedule;
    }

    /* fetch all dates match to request date for register a new schedule */
    public function reserveDates($vehicleId)
    {
        $reserved = Schedule::where('vehicle_id', $vehicleId)->select(DB::raw('DATE(date) as date'))->pluck('date')->toArray();

        return $reserved;
    }

    /* fetch list of all travel schedules*/
    public function list()
    {
        $scheduls = Schedule::query()->get();

        return $scheduls;
    }

    /* fetch available vehicles in a specific date, origin and destination */
    public function getScheduleList($data)
    {
        $vehicleSelect = ['id', 'model', 'capacity', 'description'];

        $schedules = Schedule::query()->ScheduleVehicle()->ScheduleSelection($data)
            ->Filter($data['filter'], $data['order'])->get();

        return $schedules;
    }

    public function getVehicleId($id)
    {
        $id = Schedule::query()->where('id', $id)->value('vehicle_id');

        return $id;
    }

    public function getPrice($id)
    {
        $price = Schedule::query()->where('id', $id)->value('price');

        return $price;
    }


}
