<?php


namespace App\Validations;

use App\Traits\Response;
use Hekmatinasser\Verta\Verta;
use App\Exceptions\ReserveFailedException;

class CheckRegisterScheduleDate
{
    use Response;

    /**
     * @throws ReserveFailedException
     */
    public function checkFailedDates($date, $endDate, $allDates)
    {
        if (!empty($allDates)) {
            foreach ($allDates as $eachDate)
                if (Verta::parse($date)->greaterThanOrEqualTo(Verta::parse($eachDate['date'])) &&
                    Verta::parse($date)->lessThanOrEqualTo(Verta::parse($eachDate['end_date']))) {
                    throw new ReserveFailedException('تاریخ انتخابی شروع سفر دردسترس نیست!');
                }

            if (Verta::parse($endDate)->greaterThanOrEqualTo(Verta::parse($eachDate['date'])) &&
                Verta::parse($endDate)->lessThanOrEqualTo(Verta::parse($eachDate['end_date']))) {
                throw new ReserveFailedException('تاریخ انتخابی برای پایان سفر با سفر قبلی تداخل دارد!');
            }
        }
    }

    /**
     * @throws ReserveFailedException
     */
    public function checkIsPast($date)
    {
        if(Verta::parse($date)->isPast())
        {
            throw new ReserveFailedException('this date is past');
        }
    }
}
