<?php

namespace App\Http\Requests;

use App\Traits\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response as HTTPResponse;

class UserRequest extends FormRequest
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
        return $validator =
        [
            'name' => 'required|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'gender' => 'required',
        ];

    }

    /**
     * get validation in json format.
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->getErrors(
            $validator->errors()->first(),
            HTTPResponse::HTTP_UNPROCESSABLE_ENTITY
        ));
    }
}
