<?php

namespace App\Http\Controllers;

use App\Traits\Response;
use App\repositories\ScheduleRepository;
use App\Http\Requests\ScheduleStoreRequest;
use Illuminate\Http\Response as HTTPResponse;

class ScheduleController extends Controller
{
    use Response;

    public $scheduleRepository;

    /* injection of ScheduleRepository dependency to this class: */
    public function __construct(ScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created schedule in database.
     *
     * @param  \Illuminate\Http\Request  $request
      @return \Illuminate\Http\Response
     */
    public function store(ScheduleStoreRequest $request)
    {
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified schedule in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
      @return \Illuminate\Http\Response
     */
    public function update(ScheduleStoreRequest $request, $id)
    {
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
