<?php

namespace App\Http\Controllers;

use App\Traits\Response;
use App\Gateways\Zarinpal;
use Illuminate\Support\Facades\DB;
use App\repositories\PaymentRepository;
use App\repositories\ReservationRepository;

class PaymentController extends Controller
{
    use Response;

    public $zarinpal;
    private $paymentRepository;
    public $reservatonRepository;

    /* injection of PaymentRepository, Zarinpal and ReservationRepository dependencies to this class: */
    public function __construct(Zarinpal $zarinpal,
                                PaymentRepository $paymentRepository,
                                ReservationRepository $reservationRepository)
    {
        $this->zarinpal = $zarinpal;
        $this->paymentRepository = $paymentRepository;
        $this->reservatonRepository = $reservationRepository;
    }

    /* send payment request to gateway */
    public function payRequest($id)
    {
        $user = auth('api')->user();

        $info = [
            'amount' => $this->paymentRepository->getAmount($id),
            'description' => $this->paymentRepository->getDescription($id),
            'email' => $user->email,
            'callbackUrl' => 'http://127.0.0.1:8000/api/pay/result/' . $id
        ];

        $result = $this->zarinpal->request($info);

        if (isset($result["Status"]) && $result["Status"] == 100) {
            $this->paymentRepository->update(['authority' => $result['Authority']], $id);
            // Success and redirect to pay
            $this->zarinpal->redirect($result["StartPay"]);
        } else {
            return $this->getErrors(
                "تفسیر و علت خطا : " . $result["Message"],
                "کد خطا : " . $result["Status"]
            );
        }

    }

    /* Get the payment result from the payment gateway and display the payment status to the user */
    public function pay($id)
    {
        $info = [
            'amount' => $this->paymentRepository->getAmount($id),
            'authority' => $this->paymentRepository->getAuthority($id)
        ];
        $result = $this->zarinpal->verify($info);


        if (isset($result["Status"]) && $result["Status"] == 100) {
            $data = ['مبلغ' => $result["Amount"], 'کد پیگری' => $result["RefID"], 'Authority' => $result["Authority"]];

            DB::beginTransaction();
            $this->paymentRepository->update(['refId' => $result['RefID'], 'status' => 'paid'], $id);

            $this->reservatonRepository->update(['status' => 'reserved', 'payment_id' => $id],
                $this->paymentRepository->getUser($id)->id,
                $this->paymentRepository->getCreatedDate($id));

            DB::commit();
            return $this->getMessage(
                'تراکنش با موفقیت انجام شد"',
                $result['Status'],
                $data
            );
        } else {
            return $this->getErrors('error' . $result["Message"],
                $result["Status"]);
        }
    }
}
