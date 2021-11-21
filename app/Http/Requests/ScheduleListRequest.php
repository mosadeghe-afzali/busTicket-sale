<?php

namespace App\Http\Requests;

use App\Traits\Response;
use Illuminate\Validation\Rule;
use Doctrine\Inflector\Rules\French\Rules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response as HTTPResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class ScheduleListRequest extends FormRequest
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
            'date' => 'required|date_format:Y-m-d',
            'origin' => 'required|string|max:20',
            'destination' => 'required|string|max:20',
            'filter' => ['nullable',
                Rule::in(
                    ["date", "price", "vehicles.capacity", "vehicles.model"]
                )],
            'order' => ['nullable',
                Rule::in(['asc', 'desc'])
            ],
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
