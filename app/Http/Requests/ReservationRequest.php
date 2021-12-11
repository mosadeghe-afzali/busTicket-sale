<?php

namespace App\Http\Requests;

use App\Traits\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response as HTTPResponse;

class ReservationRequest extends FormRequest
{

    use Response;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
                return [
                    'reservations.*.name' => 'required|string',
                    'reservations.*.national_code' => 'required|numeric|digits:10',
                    'reservations.*.gender' => 'required|string',
                    'reservations.*.seat_number' => 'required|numeric'
                ];

    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->getErrors(
            $validator->errors()->first(),
            HTTPResponse::HTTP_UNPROCESSABLE_ENTITY
        ));
    }
}
