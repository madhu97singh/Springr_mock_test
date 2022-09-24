<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->method()=='PATCH'){
            return [
                'name'=>'required|min:3',
                'email' =>'required|email|regex:/^[\w-]+(?:\.[\w-]+)*@(?:[\w-]+\.)+[a-zA-Z]{2,7}$/|unique:users,email', 
                'image'=>'required|mimes:png,jpeg,gif,jpg',
            ];
        }else{
            return [
                'name'=>'required|min:3',
                'email' =>'required|email|regex:/^[\w-]+(?:\.[\w-]+)*@(?:[\w-]+\.)+[a-zA-Z]{2,7}$/|unique:users,email',
                'image'=>'required|mimes:png,jpeg,gif,jpg',
                'date_of_joining'=>'required',
                'date_of_leaving'=>'required|after:date_of_joining',
            ];
        }
    }

    public function messages(){
        return[ 
            'name.required'=>'Please Enter Name.',
            'email.required'=>'Please Enter Email.',
            'email.email'=>'Please Enter Valid Email Address.',
            'email.regex'=>'Please Enter Valid Email Address.',
            'email.unique'=>'Email Already Exists.',
            'image.required'=>'Please Select Image.',
            'date_of_leaving.required'=>'Please Select Date of Leaving.',
            'date_of_joining.required'=>'Please Select Date of Joining.',
        ];
    }

}
