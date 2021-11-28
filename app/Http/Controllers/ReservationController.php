<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Traits\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\repositories\VehicleRepository;
use App\repositories\ScheduleRepository;
use App\repositories\PassengerRepository;
use App\repositories\ReservationRepository;
use Illuminate\Http\Response as HTTPResponse;

class ReservationController extends Controller
{
    use Response;

    public $vehicleRepository;
    public $scheduleRepository;
    public $passengerRepository;
    public $reservationRepository;


    /* injection of ScheduleRepository, VehicleRepository, PassengerRepository, ReservationRepository, dependencies
      * to this class: */
    public function __construct(VehicleRepository $vehicleRepository,
                                ScheduleRepository $scheduleRepository,
                                PassengerRepository $passengerRepository,
                                ReservationRepository $reservationRepository
    )
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->passengerRepository = $passengerRepository;
        $this->reservationRepository = $reservationRepository;
    }

    /* display available and reserved seats of a specific schedule*/
    public function availableSeats($id)
    {
        $vehicleId = $this->scheduleRepository->getVehicleId($id);
        $capacity = $this->vehicleRepository->getcapacity($vehicleId);
        $reserveSeats = $this->reservationRepository->reservedSeats($id);

        $seats = [];

        for ($i = 1; $i <= $capacity; $i++) {
            $passengerId = $this->reservationRepository->getPassengerId($i, $id);
            $gender = ($this->passengerRepository->getGender($passengerId) == 'f') ? ' خانم' : ' آقا';

            if (!in_array($i, $reserveSeats)) {

                $seats[] = [$i => 'available'];
            } else {
                $seats[] = [$i => 'reserve', 'جنسیت' => $gender];
            }
        }
        return $this->getMessage(
            'لیست صندلی ها با موفقیت بازیابی شد.',
            HTTPResponse::HTTP_OK,
            $seats,
        );

    }

    /* reserve requested seats of users and print a bilم */
    public function doReserve(Request $request, $id)
    {
        $data = $request->json('reservations');

        DB::beginTransaction();

        foreach ($data as $item) {
            if (in_array($item['seat_number'], $this->reservationRepository->reservedSeats($id)))
                return response()->json('این صندلی رزرو شده است', HTTPResponse::HTTP_UNPROCESSABLE_ENTITY);

            $passenger = $this->passengerRepository->store([
                'name' => $item['name'],
                'national_code' => $item['national_code'],
                'gender' => $item['gender']
            ]);

            $reservation = $this->reservationRepository->store([
                'seat_number' => $item['seat_number'],
                'reserve_date' => Carbon::now(),
                'schedule_id' => $id,
                'user_id' => auth('api')->id(),
                'passenger_id' => $passenger->id,
            ]);
        }

        $numberOfSeats = count($data);
        $price = $this->scheduleRepository->getPrice($id) * $numberOfSeats;

        $bill = [
            'تعداد صندلی رزرو شده' => $numberOfSeats,
            'هزینه قابل پرداخت' => $price
        ];

        DB::commit();

        return $this->getMessage(
            'رسید درخواست رزرو کاربر با موفقیت چاپ شد.',
            HTTPResponse::HTTP_OK,
            $bill,
        );
    }

}
