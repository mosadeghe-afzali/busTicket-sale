<?php
namespace App\repositories;

use App\Models\Vehicle;

class VehicleRepository
{
    /**
     * query for store a new vehicle.
     *
     * @param array $data
     */
    public function store(array $data)
    {
        Vehicle::create($data);
    }

    /**
     * query for update a vehicle.
     *
     * @param array $data
     * @param int $id
     */
    public function update(array $data, int $id)
    {
        Vehicle::query()->findOrFail($id)->update($data);
    }

    /**
     * query for delete a vehicle.
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();
    }

    /**
     * getting a vehicle id.
     *
     * @param $tag
     * @return int $vehicleId
     */
    public function vehicleId($tag)
    {
        $vehicleId = Vehicle::query()->where('tag', $tag)->value('id');

        return $vehicleId;
    }

    /**
     * get list of vehicles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function list()
    {
        return Vehicle::query()->get();
    }

    /**
     * get a vehicle capacity.
     *
     * @param int $id
     * @return int $capacity
     */
    public function getcapacity($id)
    {
        $capacity = Vehicle::query()->where('id', $id)->value('capacity');

        return $capacity;
    }
}
