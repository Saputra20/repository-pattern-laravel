<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiResponse;

class BiodataRequest extends FormRequest
{
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
            "first_name" => ["required"],
            "last_name" => ["required"],
            "place_of_birth" => ["required"],
            "date_of_birth" => ["required"],
            "gender" => ["required" , 'in:Male,Female'],
            "provice" => ["required"],
            "regency" => ["required"],
        ];
    }

    /**
     * TODO
     *  Return costume response validation
     * 
     * @return object
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ApiResponse::error("validation error", 422, $validator->errors()));
    }
}
