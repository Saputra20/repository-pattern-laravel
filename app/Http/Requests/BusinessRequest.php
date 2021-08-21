<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiResponse;

class BusinessRequest extends FormRequest
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
            'avatar' => ['required'],
            'name' => ['required'],
            'npwp' => ['required'],
            'website' => ['required'],
            'phone' => ['required'],
            'address' => ['required'],
            'social_media' => ['present' , 'array' , 'min:1'],
            'social_media.*.platform' => ['required'],
            'social_media.*.link' => ['required'],
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
