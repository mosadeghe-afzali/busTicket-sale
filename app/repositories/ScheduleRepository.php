<?php
namespace App\repositories;

use App\Models\Schedule;

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

}
