<?php

namespace App\repositories;

use Carbon\Carbon;
use App\Models\Reservation;

class ReservationRepository
{
    /**
     * fetch reserved seats of specific schedule.
     *
     * @param int $id
     * @return array $reservedSeats
     */
    public function reservedSeats(int $id)
    {
        $reservedSeats = Reservation::query()->where('schedule_id', $id)->pluck('seat_number')->toArray();

        return $reservedSeats;
    }

    /**
     * fetch passenger id of a specific seat in a schedule.
     *
     * @param int $seatNumber
     * @param int $id
     * @return int $PassengerId
     */
    public function getPassengerId(int $seatNumber, int $id)
    {
        $PassengerId = Reservation::query()->where('schedule_id', $id)->where('seat_number', $seatNumber)
            ->value('passenger_id');

        return $PassengerId;
    }

    /**
     * store a new reserve request in database.
     *
     * @param array $data
     */
    public function store(array $data)
    {
        Reservation::query()->create($data);
    }

    /**
     * get pending reserves.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function cancelReserve()
    {
        $reserves = Reservation::query()->where('status', 'pending')
            ->where('reserve_date', '<', Carbon::now()->subMinutes(15))->get();

        return $reserves;
    }

    /**
     * update payment status of a reservation in database.
     *
     * @param array $data
     * @param int $userId
     * @param $date
     */
    public function update(array $data, int $userId, $date)
    {
        Reservation::query()->where('user_id', $userId)->where('created_at' , $date)->update($data);
    }

    /**
     *  show ticket of a specific reservation ofter successful payment.
     *
     * @param int $paymentId
     * @return array $ticket
     */
    public function ticket(int $paymentId)
    {
        $passenger_select = ['id', 'name', 'national_code'];
        $schedule_select = ['id', 'date', 'end_date', 'origin', 'destination', 'price', 'vehicle_id'];

        $ticket = Reservation::query()->where('payment_id', $paymentId)->
            select('id', 'schedule_id', 'passenger_id', 'seat_number')
            ->CheckSchedule($schedule_select)->CheckPassenger($passenger_select)->get()->toArray();

        return $ticket;
    }
}
