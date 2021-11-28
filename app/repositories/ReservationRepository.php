<?php

namespace App\repositories;

use App\Models\Reservation;

class ReservationRepository
{
    /* fetch reserved seats of specific schedule */
    public function reservedSeats($id)
    {
        $reservedSeats = Reservation::query()->where('schedule_id', $id)
            ->select('seat_number')->pluck('seat_number')->toArray();

        return $reservedSeats;
    }

    /* fetch passenger id of a specific seat in a schedule */
    public function getPassengerId($seatNumber, $id)
    {
        $id = Reservation::query()->where('schedule_id', $id)->where('seat_number', $seatNumber)
            ->value('passenger_id');

        return $id;
    }

    /* store a new reserve request in database */
    public function store($data)
    {
        $reservation = Reservation::query()->insert($data);

        return $reservation;
    }

}
