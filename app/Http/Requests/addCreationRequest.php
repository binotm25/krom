<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class addCreationRequest extends Request
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
        //dd($request->all());
        return [
            'title'         =>  'required|max:60',
            'sel-int'       =>  'required|numeric',
            'desc'          =>  'required',
            'uploadFile.*'  =>  'required|image',
            'uploadFile1.*' =>  'image'
        ];
    }
}
