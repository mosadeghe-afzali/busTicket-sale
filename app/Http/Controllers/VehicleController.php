<?php

namespace App\Http\Controllers;

use App\Traits\Response;
use App\repositories\VehicleRepository;
use App\repositories\CompanyRepository;
use App\Http\Requests\VehicleStoreRequest;
use Illuminate\Http\Response as HTTPResponse;

class VehicleController extends Controller
{
    use Response;

    public $vehicleRepository;
    public $companyRepository;

    /* injection of CompanyRepository and VehicleRepository dependencies to this class: */
    public function __construct(CompanyRepository $companyRepository, VehicleRepository $vehicleRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * Display a listing of the resource.
     *
      @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = $this->vehicleRepository->list();

       return $this->getMessage(
           'لیست اتوبوس ها با موفقیت بازیابی شد.',
            HTTPResponse::HTTP_OK,
           $vehicles,
       );
    }

    /**
     * Store a newly created Vehicle in database.
     *
     * @param \Illuminate\Http\Request $request
      @return \Illuminate\Http\Response as HTTPResponse;
     */
    public function store(VehicleStoreRequest $request)
    {
        $companyId = $this->companyRepository->companyId($request->company_name);

        $data = [
            'model' => $request->model,
            'capacity' => $request->capacity,
            'company_id' => $companyId,
            'description' => $request->description,
            'tag' => $request->tag,
            'registrar' => auth('api')->id(),
        ];

        $this->vehicleRepository->store($data);

        return $this->getMessage(
            'وسیله نقلیه مورد نظر با موفقیت ثبت شد',
            HTTPResponse::HTTP_OK);
    }

    /**
     * Update the specified Vehicle in database.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
      @return \Illuminate\Http\Response
     */
    public function update(VehicleStoreRequest $request, $id)
    {
        $data = $request->all();
        $company_id = $this->companyRepository->companyId($request->company_name);
        $data['company_id'] = $company_id;
        $data['editor'] = auth('api')->id();

        $vehicle = $this->vehicleRepository->update($data, $id);

        return $this->getMessage(
            'وسیله نقلیه مورد نظر با موفقیت آپدیت شد',
            HTTPResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
      @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->vehicleRepository->delete($id);

        return $this->getMessage(
            'وسیله نقلیه مورد نظر با موفقیت حدف شد',
            HTTPResponse::HTTP_OK
        );
    }
}
