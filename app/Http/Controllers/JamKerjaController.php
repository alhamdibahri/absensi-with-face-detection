<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JamKerja;
use App\Models\Company;

class JamKerjaController extends Controller
{
    public function index(){
        $jam_kerja = JamKerja::all();
        return view('jam-kerja.index', compact('jam_kerja'));
    }

    public function saveData(Request $request){
        $payload = $request->all();
        $company = Company::first();
        if($request->ajax()){
            foreach($payload['data'] as $item){
                $cekJamKerja = JamKerja::find($item['id']);
    
                if($cekJamKerja){
                    $cekJamKerja->update([
                        'hari' => $item['hari'],
                        'kondisi' => $item['kondisi'],
                        'masuk_kerja' => $item['jam_masuk'],
                        'pulang_kerja' => $item['jam_pulang'], 
                        'company_id' => $company->id
                    ]);
                }else{
                    JamKerja::create([
                        'hari' => $item['hari'],
                        'kondisi' => $item['kondisi'],
                        'masuk_kerja' => $item['jam_masuk'],
                        'pulang_kerja' => $item['jam_pulang'], 
                        'company_id' => $company->id
                    ]);
                }
            }
            \Session::flash('success','Jam Kerja Berhasil Di Perbaharui');
            $response = array(
                'status' => 'success',
                'url' => route('jam-kerja.index'),
            );
            return $response;
        }
        
    }
}
