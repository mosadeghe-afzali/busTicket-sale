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
        $reservation = Reservation::query()->create($data);

        return $reservation;
    }

    /* cancellation of pending reserves after 15 minutes */
    public function cancelReserve()
    {
        $reserves = Reservation::query()->where('status', 'pending')
            ->where('reserve_date', '<', Carbon::now()->subMinutes(15))->get();

        return $reserves;
    }

    /* update payment status of a reservation in database */
    public function update($data, $userId, $date)
    {
        return Reservation::query()->where('user_id', $userId)->where('created_at' , $date)->update($data);
    }

    /* show ticket of a specific reservation ofter successful payment */
    public function ticket($paymentId)
    {
        $passenger_select = ['id', 'name', 'national_code'];
        $schedule_select = ['id', 'date', 'end_date', 'origin', 'destination', 'price', 'vehicle_id'];

        $ticket = Reservation::query()->where('payment_id', $paymentId)->
            select('id', 'schedule_id', 'passenger_id', 'seat_number')
            ->CheckSchedule($schedule_select)->CheckPassenger($passenger_select)->get()->toArray();

        return $ticket;
    }
}
