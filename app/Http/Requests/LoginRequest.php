<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiResponse;

class LoginRequest extends FormRequest
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
            "email" => ["required", "email"],
            "password" => ["required"]
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        // use trans instead on Lang 
        return [
            'email' => "Format email tidak valid",
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
