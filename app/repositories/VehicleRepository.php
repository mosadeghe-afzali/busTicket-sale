<?php
namespace App\repositories;

use App\Models\Vehicle;

class VehicleRepository
{
    /* query for store a new vehicle */
    public function store($data)
    {
        $vehicle = Vehicle::create($data);
        return $vehicle;
    }
    /* query for update a vehicle */
    public function update($data, $id)
    {
        $vehicle = Vehicle::query()->findOrFail($id);
        $vehicle->update($data);

        return $vehicle;
    }
   /* query for delete a vehicle */
    public function delete($id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->delete();

        return $vehicle;
    }
    /* getting a vehicle id */
    public function vehicleId($tag)
    {
        $vehicle = Vehicle::query()->where('tag', $tag)->value('id');
    }

}
