<?php
namespace App\repositories;

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
    public function reserveDates($vehicleId)
    {

        $reserved = Schedule::where('vehicle_id', $vehicleId)->select(DB::raw('DATE(date) as date'))->pluck('date')->toArray();

        return $reserved;
    }

    public function list()
    {
        $scheduls = Schedule::query()->get();

        return $scheduls;
    }

}
