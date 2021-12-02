<?php

namespace App\repositories;

use App\Models\Reservation;
use Carbon\Carbon;

class ReservationRepository
{
    /* fetch reserved seats of specific schedule */
    public function reservedSeats($id)
    {
        $reservedSeats = Reservation::query()->where('schedule_id', $id)->pluck('seat_number')->toArray();

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

    /* cancellation of pending reserves after 15 minutes */
    public function cancelReserve()
    {
        $reserves = Reservation::query()->where('status', 'pending')
            ->where('reserve_date', '<' , Carbon::now()->subMinutes(15))->get();

        return $reserves;
    }



}
