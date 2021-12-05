<?php

namespace App\repositories;

use App\Models\Passenger;

class PassengerRepository
{
    /* fetch gender of passengers reserved seats in database */
    public function getGender($id)
    {
        $gender = Passenger::query()->where('id', $id)->value('gender');

        return $gender;
    }

    /* store a new passenger in database */
    public function store($data)
    {
        $passenger = Passenger::query()->firstOrCreate(
            ['national_code' => $data['national_code']],
            ['name' => $data['name'], 'gender' => $data['gender']]
        );

        return $passenger;
    }

    /* delete a passenger*/
    public function delete($id)
    {
        return Passenger::query()->findOrFail($id)->delete();
    }

}
