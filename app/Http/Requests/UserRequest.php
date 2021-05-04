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

        if($this->method() == "PATCH" || $this->method() == "PUT"){
            $rules_email = "required|unique:users,email,".$this->get('id');
            $rules_password = "nullable";
        }else{
            $rules_email = "required|unique:users";
            $rules_password = "required";
        }


        return [
            'name' => 'required',
            'email' => $rules_email,
            'password' => $rules_password
        ];
    }
}
