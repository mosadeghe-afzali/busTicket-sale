<?php


namespace App\Validations;


use App\Exceptions\ReserveFailedException;
use App\Traits\Response;
use Carbon\Carbon;
use Illuminate\Http\Response as HTTPResponse;

class CheckRegisterScheduleDate
{
    use Response;

    /**
     * @throws ReserveFailedException
     */
    public function checkFailedDates($date, $allDates)
    {
        if(in_array(Date("Y-m-d", strtotime($date)), $allDates))
        {

            throw new ReserveFailedException(response()->json(
                'تاریخ انتخابی دردسترس نیست!',
                HTTPResponse::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE));
        }
    }

    /**
     * @throws ReserveFailedException
     */
    public function checkIsPast($date)
    {
        if(Carbon::parse($date)->isPast())
        {
            throw new ReserveFailedException($this->getErrors('this date is past',
                HTTPResponse::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE));
        }
    }

}
