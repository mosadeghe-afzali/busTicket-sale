<?php

namespace App\repositories;

use App\Models\Schedule;

class ScheduleRepository
{
    /**
     * query for store a new schedule.
     *
     * @param array $data
     */
    public function store($data)
    {
        Schedule::create($data);
    }

    /**
     * query for update a schedule.
     *
     * @param int $id
     * @param array $data

     */
    public function update($id, $data)
    {
        $schedule = Schedule::find($id)->update($data);
    }

    /**
     * fetch all dates match to request date for register a new schedule.
     *
     * @param int $vehicleId
     * @return array $reservedDates
     */
    public function reserveDates(int $vehicleId)
    {
        $reservedDates = Schedule::where('vehicle_id', $vehicleId)->select('date','end_date')
            ->get()->toArray();

        return $reservedDates;
    }

    /**
     * fetch list of all travel schedules.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function list()
    {
        return Schedule::query()->get();
    }

    /**
     * fetch available vehicles in a specific date, origin and destination.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getScheduleList($data)
    {
        $vehicleSelect = ['id', 'model', 'capacity', 'description'];

        return Schedule::query()->ScheduleVehicle()->ScheduleSelection($data)
            ->Filter($data['filter'], $data['order'])->get();
    }

    /**
     * query to get vehicle id related to a specific schedule.
     *
     * @param int $id
     * @return int $vehicleId
     */
    public function getVehicleId(int $id)
    {
        $vehicleId = Schedule::query()->where('id', $id)->value('vehicle_id');

        return $vehicleId;
    }

    /**
     * get price of a specific schedule.
     *
     * @param int $id
     * @return int $price
     */
    public function getPrice(int $id)
    {
        $price = Schedule::query()->where('id', $id)->value('price');

        return $price;
    }

    /**
     * decrease capacity of an schedule.
     *
     * @param int $id
     */
    public function decrementRemainingCapacity(int $id)
    {
        Schedule::query()->find($id)->decrement('remaining_capacity');
    }

    /**
     * increase capacity of an schedule.
     *
     * @param int $id
     */
    public function incrementRemainingCapacity(int $id)
    {
        Schedule::query()->find($id)->increment('remaining_capacity');
    }
}
