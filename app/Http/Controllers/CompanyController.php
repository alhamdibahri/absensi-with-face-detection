<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Requests\CompanyRequest;
use Storage;

class CompanyController extends Controller
{
    public function index(){
        $company = Company::first();
        return view('company.index', compact('company'));
    }

    public function store(CompanyRequest $request)
    {
        $payload = $request->all();
        $payload['user_id'] = \Auth::user()->id;
        if($request->hasFile('logo_company')){
            $payload['logo_company'] = $this->uploadFoto($request);
        }

        if($request->ajax()){
            Company::create($payload);
            \Session::flash('success','Data Company Berhasil Di Simpan');
            $response = array(
                'status' => 'success',
                'url' => route('company.index'),
            );
            return $response;
        }
    }

    public function update(CompanyRequest $request, $id){
        $payload = $request->all();
        $payload['user_id'] = \Auth::user()->id;
        $company = Company::findOrFail($id);
        if($request->hasFile('logo_company')){
            $payload['logo_company'] = $this->updateFoto($company, $request);
        }else{
            $payload['logo_company'] = $company->logo_company;
        }
        
        if($request->ajax()){
            $company->update($payload);
            \Session::flash('success','Data Company Berhasil Di Update');
            $response = array(
                'status' => 'success',
                'url' => route('company.index'),
            );
            return $response;
        }
    }

    public function uploadFoto(CompanyRequest $request){
        $foto = $request->file('logo_company');
        $ext  = $foto->getClientOriginalExtension();
        if($request->file('logo_company')->isValid()){
            $foto_name = date('YmdHis'). ".$ext";
            $upload_path = 'logo_company';
            $request->file('logo_company')->move($upload_path, $foto_name);
            return $foto_name;
        }
        return false;
    }

    public function updateFoto($company, CompanyRequest $request){
        if($request->hasFile('logo_company')){

            //hapus foto lama jika ada foto baru
            $exist = Storage::disk('logo_company')->exists($company->logo_company);
            if(isset($company->logo_company) && $exist){
                $delete = Storage::disk('logo_company')->delete($company->logo_company);
            }

            //upload foto baru
            $foto = $request->file('logo_company');
            $ext  = $foto->getClientOriginalExtension();
            if($foto->isValid()){
                $foto_name = date('YmdHis'). ".$ext";
                $upload_path = 'logo_company';
                $foto->move($upload_path, $foto_name);
                return $foto_name;
            }
            
        }
    }
}
