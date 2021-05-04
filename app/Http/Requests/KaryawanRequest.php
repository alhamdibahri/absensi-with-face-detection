<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KaryawanRequest extends FormRequest
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
            $rules_nip = "required|unique:karyawan,nip,".$this->get('id');
            $rules_telp = "required|unique:karyawan,no_telp,".$this->get('id');
        }else{
            $rules_nip = "required|unique:karyawan";
            $rules_telp = "required|unique:karyawan";
        }


        return [
            'nip' => $rules_nip,
            'nama_karyawan' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'no_telp' => $rules_telp,
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'foto_karyawan' => 'required',
        ];
    }
}
