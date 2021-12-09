<?php

namespace App\Http\Controllers;

use App\Traits\Response;
use App\Notifications\SendTicket;
use Illuminate\Support\Facades\App;
use App\repositories\PaymentRepository;
use Illuminate\Support\Facades\Storage;
use App\repositories\ReservationRepository;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Response as HTTPResponse;

class TicketController extends Controller
{
    use Response;

   private $reservationRepository;
   private $paymentRepository;

   public function __construct(ReservationRepository $reservationRepository, PaymentRepository $paymentRepository)
   {
       $this->reservationRepository = $reservationRepository;
       $this->paymentRepository = $paymentRepository;
   }

    /* display tickets of user after payment: */
    public function ticket($paymentId)
    {
        $ticketData = $this->reservationRepository->ticket($paymentId);

        foreach ($ticketData as $data) {
            $tickets[] = [
                'seat_number' => $data['seat_number'],
                'price' => $data['schedule']['price'],
                'origin' => $data['schedule']['origin'],
                'destination' => $data['schedule']['destination'],
                'date' => $data['schedule']['date'],
                'end_date' => $data['schedule']['end_date'],
                'passenger_name' => $data['passenger']['name'],
                'passenger_national_code' => $data['passenger']['national_code']
            ];
        }

        $user = $this->paymentRepository->getUser($paymentId);
        Notification::send($user, new SendTicket($tickets));

        return $this->getMessage(
            'اطلاعات بلیط با موفقیت بازیابی شد.',
            HTTPResponse::HTTP_OK,
            $tickets
        );
    }

    /* creat pdf format of ticket and show */
    public function getPdfTicket($paymentId)
    {
        $data = json_decode($this->ticket($paymentId)->getContent(), true);
        $tickets = $data['response'];

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('ticket', compact('tickets'));
        $pdf->stream('download.pdf');

        if(!file_exists('public/pdf/ticket' . $paymentId . 'pdf'))
            storage::put('public/pdf/ticket' . $paymentId . '.pdf' ,  $pdf->stream('download.pdf'));
        $url = storage::url('ticket' . $paymentId . '.pdf');

        return $this->getMessage('درخواست با موفقیت انحام شد',
            HTTPResponse::HTTP_OK,
            $url);

    }
}
