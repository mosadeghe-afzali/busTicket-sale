<?php

namespace App\repositories;

use App\Models\Passenger;

class PassengerRepository
{
    /**
     * fetch gender of passengers reserved seats in database.
     *
     * @param int $id
     * @return string $gender
     */
    public function getGender($id)
    {
        $gender = Passenger::query()->where('id', $id)->value('gender');

        return $gender;
    }

    /**
     * store a new passenger in database.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($data)
    {
        $passenger = Passenger::query()->firstOrCreate(
            ['national_code' => $data['national_code']],
            ['name' => $data['name'], 'gender' => $data['gender']]
        );

        return $passenger;
    }

    /**
     * delete a passenger.
     *
     * @param int $id
     */
    public function delete($id)
    {
        Passenger::query()->findOrFail($id)->delete();
    }
}
