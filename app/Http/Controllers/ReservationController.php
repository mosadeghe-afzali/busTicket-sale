<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Traits\Response;
use Illuminate\Support\Facades\DB;
use App\repositories\VehicleRepository;
use App\repositories\PaymentRepository;
use App\repositories\ScheduleRepository;
use App\repositories\PassengerRepository;
use App\Http\Requests\ReservationRequest;
use App\repositories\ReservationRepository;
use Illuminate\Http\Response as HTTPResponse;

class ReservationController extends Controller
{
    use Response;

    private $vehicleRepository;
    private $scheduleRepository;
    private $paymentRepository;
    private $passengerRepository;
    private $reservationRepository;

    /**
     * create a new reservation instance
     *
     * @param VehicleRepository $vehicleRepository
     * @param PaymentRepository $paymentRepository
     * @param ScheduleRepository $scheduleRepository
     * @param PassengerRepository $passengerRepository
     * @param ReservationRepository $reservationRepository
     */
    public function __construct(VehicleRepository $vehicleRepository,
                                PaymentRepository $paymentRepository,
                                ScheduleRepository $scheduleRepository,
                                PassengerRepository $passengerRepository,
                                ReservationRepository $reservationRepository
    )
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->paymentRepository = $paymentRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->passengerRepository = $passengerRepository;
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * display available and reserved seats of a specific schedule
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function availableSeats($id)
    {
        $vehicleId = $this->scheduleRepository->getVehicleId($id);
        $capacity = $this->vehicleRepository->getcapacity($vehicleId);
        $reserveSeats = $this->reservationRepository->reservedSeats($id);

        $seats = [];

        for ($i = 1; $i <= $capacity; $i++) {
            if (!in_array($i, $reserveSeats)) {
                $seats[] = [$i => 'available'];
                continue;
            }
            $passengerId = $this->reservationRepository->getPassengerId($i, $id);
            $gender = ($this->passengerRepository->getGender($passengerId) == 'f') ? ' خانم' : ' آقا';
            $seats[] = [$i => 'reserve', 'جنسیت' => $gender];
        }

        return $this->getMessage(
            'لیست صندلی ها با موفقیت بازیابی شد.',
            HTTPResponse::HTTP_OK,
            $seats,
        );
    }

    /**
     * reserve requested seats of users and print a bil
     *
     * @param \App\Http\Requests\ReservationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function doReserve(ReservationRequest $request, $id)
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

             $this->reservationRepository->store([
                'seat_number' => $item['seat_number'],
                'reserve_date' => Carbon::now(),
                'schedule_id' => $id,
                'user_id' => auth('api')->id(),
                'passenger_id' => $passenger->id,
            ]);
            $this->scheduleRepository->decrementRemainingCapacity($id);
        }

        $numberOfSeats = count($data);
        $price = $this->scheduleRepository->getPrice($id) * $numberOfSeats;

        $this->paymentRepository->store([
            'amount' => $price,
            'description' => 'تعداد صندلی رزرو شده:' . $numberOfSeats,
            'user_id' => auth('api')->id(),
        ]);

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
