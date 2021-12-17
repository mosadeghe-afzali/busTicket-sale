<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Traits\Response;
use Hekmatinasser\Verta\Verta;
use App\repositories\VehicleRepository;
use App\repositories\ScheduleRepository;
use App\Http\Requests\ScheduleListRequest;
use App\Http\Requests\ScheduleStoreRequest;
use Illuminate\Http\Response as HTTPResponse;
use App\Validations\CheckRegisterScheduleDate;

class ScheduleController extends Controller
{
    use Response;

    public $scheduleRepository;
    private $vehicleRepository;
    public $checkRegisterScheduleDate;

    /**
     * injection of ScheduleRepository dependency to this class:
     *
     * @param ScheduleRepository $scheduleRepository
     * @param VehicleRepository $vehicleRepository
     * @param CheckRegisterScheduleDate $checkRegisterScheduleDate
     */
    public function __construct(ScheduleRepository $scheduleRepository,
                                VehicleRepository $vehicleRepository,
                                CheckRegisterScheduleDate $checkRegisterScheduleDate)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->checkRegisterScheduleDate = $checkRegisterScheduleDate;
    }


    /**
     * Display a listing of the schedules.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $schedules = $this->scheduleRepository->list();

        return $this->getMessage(
            'لیست برنامه سفرهای ثبت شده با موفقیت بازیابی شد',
            HTTPResponse::HTTP_OK,
            $schedules,
        );
    }

    /**
     * Store a newly created schedule in database.
     *
     * @param ScheduleStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ReserveFailedException
     */
    public function store(ScheduleStoreRequest $request)
    {
        $this->checkRegisterScheduleDate->checkFailedDates($request->date,
                                                           $request->end_date,
                                                           $this->scheduleRepository->reserveDates($request->vehicle_id)
                                                           );
        $this->checkRegisterScheduleDate->checkIsPast($request->date);

        $data = $request->all();
        $data['remaining_capacity'] = $this->vehicleRepository->getcapacity($data['vehicle_id']);
        $data['registrar'] = auth('api')->id();
        $this->scheduleRepository->store($data);

        return $this->getMessage(
            'برنامه مورد نظر با موفقیت ثبت شد',
            HTTPResponse::HTTP_OK
        );
    }

    /**
     * Update the specified schedule in database.
     *
     * @param ScheduleStoreRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \App\Exceptions\ReserveFailedException
     */
    public function update(ScheduleStoreRequest $request, $id)
    {
//        $this->checkRegisterScheduleDate->checkFailedDates($request->date,$request->end_date,
//            $this->scheduleRepository->reserveDates($request->vehicle_id));
        $this->checkRegisterScheduleDate->checkIsPast($request->date);

        $data = $request->all();
        $data['editor'] = auth('api')->id();
        $this->scheduleRepository->update($id, $data);

        return $this->getMessage(
            'برنامه مورد نظر با موفقیت آپدیت شد',
            HTTPResponse::HTTP_OK
        );
    }

    /**
     * display list of vehicles in a specific date for a specific origin and destination
     *
     * @param ScheduleListRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(ScheduleListRequest $request)
    {
//        $this->checkRegisterScheduleDate->checkIsPast($request->date);

        $data = [
            'date' => Carbon::instance(Verta::parse($request->date)->datetime())->format('Y-m-d'),
            'origin' => $request->origin,
            'destination' => $request->destination,
            'filter' => $request->filter,
            'order' => $request->order ?? 'asc'
        ];

        $schedules = $this->scheduleRepository->getScheduleList($data);

        if ($schedules->isEmpty())
            return $this->getMessage(
                'موردی یافت نشد',
                HTTPResponse::HTTP_OK
            );

        return $this->getMessage(
            'لیست برنامه سفر ها با موفقیت بازیابی شد.',
            HTTPResponse::HTTP_OK,
            $schedules,
        );

    }
}
