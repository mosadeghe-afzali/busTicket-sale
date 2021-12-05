<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\SendTicket;
use App\repositories\PaymentRepository;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use App\Traits\Response;
use Illuminate\Support\Facades\Response as jsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\repositories\VehicleRepository;
use App\repositories\ScheduleRepository;
use App\repositories\PassengerRepository;
use App\Http\Requests\ReservationRequest;
use App\repositories\ReservationRepository;
use Illuminate\Http\Response as HTTPResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;

class ReservationController extends Controller
{
    use Response;

    private $vehicleRepository;
    private $scheduleRepository;
    private $paymentRepository;
    private $passengerRepository;
    private $reservationRepository;


    /* injection of ScheduleRepository, VehicleRepository, PassengerRepository, ReservationRepository, dependencies
      * to this class: */
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

    /* display available and reserved seats of a specific schedule*/
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

    /* reserve requested seats of users and print a bilم */
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

            $reservation = $this->reservationRepository->store([
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

        $pay = $this->paymentRepository->store([
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

    /* display tickets of user after payment: */
    public function ticket($paymentId)
    {
       $ticketData = $this->reservationRepository->ticket($paymentId);

        foreach ($ticketData as $tickets) {
            $ticket = [
                'seat_number' => $tickets['seat_number'],
                'price' => $tickets['schedule']['price'],
                'origin' => $tickets['schedule']['origin'],
                'destination' => $tickets['schedule']['destination'],
                'date' => $tickets['schedule']['date'],
                'end_date' => $tickets['schedule']['end_date'],
                'passenger_name' => $tickets['passenger']['name'],
                'passenger_national_code' => $tickets['passenger']['national_code']
            ];
        }

       $user = $this->paymentRepository->getUser($paymentId);
//       Notification::send($user, new SendTicket($ticket));

        return $this->getMessage(
            'اطلاعات بلیط با موفقیت بازیابی شد.',
            HTTPResponse::HTTP_OK,
            $ticket
        );
    }

    /* creat pdf format of ticket and show"
    public function getPdfTicket()
    {
        $pdf = App::make('dompdf.wrapper');
        return $pdf->loadView('ticket')->save(public_path() . 'data')->stream('download.pdf');

    }

}
