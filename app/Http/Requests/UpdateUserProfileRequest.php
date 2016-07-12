<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateUserProfileRequest extends Request
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
            'name'              =>  'required|string|between:2,40',
            'email'             =>  'required|email',
            'city'              =>  'required|string',
            'country_code'      =>  'required|alpha',
            'zip_code'          =>  'required|numeric',
            'my_story'          =>  'max:100000',
            'my_work_my_life'   =>  'max:100000'
        ];
    }
}
