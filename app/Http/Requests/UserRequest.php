<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

            'full_name'        =>  'required|regex:/^[(A-Za-z\s)]+$/u|min:3|max:50',
            'email'            => 'required|email|min:4|max:80',
            'joinDate'       => 'required|date',
            'leaveDate'      =>'date|nullable',
            'workStatus'      =>'required|regex:/^[(0-9)]+$/u|min:1|max:1|nullable',


        ];
    }
    public function messages()
    {
        return [
            'required' => 'Please enter value for :attribute',
            'regex' => ':attribute is Invalid.' ,
            'unique' => ':attribute Already Exist. Try Another!.',
            'min' => 'Minimum length should be :min for :attribute',
            'max' => 'Max length should be :max for :attribute',
            'email' => 'Invalid :attribute Given.'
        ];
    }

    public function attributes()
    {
        return [
             'full_name'        => "Full Name",
             'email'            => "Email",
             'join_date'        => "Join Date",
             'leave_date'       => "Leave Date",
             'job_status'       => "Still Work ",


        ];
    }


}
