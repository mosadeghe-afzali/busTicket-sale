<?php

namespace App\Http\Controllers;

use App\Traits\Response;
use App\repositories\ScheduleRepository;
use App\Http\Requests\ScheduleStoreRequest;
use Illuminate\Http\Response as HTTPResponse;
use App\Validations\CheckRegisterScheduleDate;

class ScheduleController extends Controller
{
    use Response;

    public $scheduleRepository;
    public $checkRegisterScheduleDate;

    /* injection of ScheduleRepository dependency to this class: */
    public function __construct(ScheduleRepository $scheduleRepository, CheckRegisterScheduleDate $checkRegisterScheduleDate)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->checkRegisterScheduleDate = $checkRegisterScheduleDate;
    }

    /**
     * Display a listing of the schedules.
     *
      @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = $this->scheduleRepository->list();

        return $this->getMessage(
            $schedules,
            HTTPResponse::HTTP_OK
        );
    }

    /**
     * Store a newly created schedule in database.
     *
     * @param \Illuminate\Http\Request $request
      @return \Illuminate\Http\Response
     */
    public function store(ScheduleStoreRequest $request)
    {
        $this->checkRegisterScheduleDate->checkFailedDates($request->date, $this->scheduleRepository->reserveDates($request->vehicle_id));
        $this->checkRegisterScheduleDate->checkIsPast($request->date);

        $data = $request->all();
        $data['registrar'] = auth('api')->id();
        $this->scheduleRepository->store($data);

        return $this->getMessage(
            'برنامه مورد نظر با موفقیت ثبت شد',
            HTTPResponse::HTTP_OK
        );

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified schedule in database.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
      @return \Illuminate\Http\Response
     */
    public function update(ScheduleStoreRequest $request, $id)
    {
        $this->checkRegisterScheduleDate->checkFailedDates($request->date, $this->scheduleRepository->reserveDates($request->vehicle_id));
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
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
