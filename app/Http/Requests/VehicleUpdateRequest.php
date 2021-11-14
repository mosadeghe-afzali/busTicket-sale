<?php

namespace App\Http\Requests;

use App\Traits\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response as HTTPResponse;

class VehicleUpdateRequest extends FormRequest
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
            'model' => 'nullable|string|min:3|max:50',
            'capacity' => 'nullable|numeric',
            'company_name' => 'nullable|string',
            'description' => 'nullable|string|min:3|max:200'
        ];
    }
    /* overriding the failedValidation method for return json validation response in api */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->getErrors(
            $validator->errors()->first(),
            HTTPResponse::HTTP_UNPROCESSABLE_ENTITY
        ));
    }
}
