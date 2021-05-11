<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Http\Requests\KaryawanRequest;
use Storage;

class KaryawanController extends Controller
{

    public function welcome(){
        $users = Karyawan::all();
        return view('welcome', compact('users'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $karyawans = Karyawan::all();
        return view('karyawan.index', compact('karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KaryawanRequest $request)
    {
        $payload = $request->all();

        if($request->hasFile('foto_karyawan')){
            $payload['foto_karyawan'] = $this->uploadFoto($request, $payload['nama_karyawan']);
        }

        if($request->ajax()){
            Karyawan::create($payload);
            \Session::flash('success','Data Karyawan Berhasil Di Simpan');
            $response = array(
                'status' => 'success',
                'url' => route('karyawan.index'),
            );
            return $response;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KaryawanRequest $request, $id)
    {
        $payload = $request->all();
        $karyawan = Karyawan::findOrFail($id);
        if($request->hasFile('foto_karyawan')){
            $payload['foto_karyawan'] = $this->updateFoto($karyawan, $request, $payload['nama_karyawan']);
        }else{
            $payload['foto_karyawan'] = $karyawan->foto_karyawan;
        }
        
        if($request->ajax()){
            $karyawan->update($payload);
            \Session::flash('success','Data Karyawan Berhasil Di Update');
            $response = array(
                'status' => 'success',
                'url' => route('karyawan.index'),
            );
            return $response;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $this->deleteFoto($karyawan);
        if($karyawan->delete()){
            \Session::flash('success','Data Karyawan Berhasil Di Hapus');
            $response = array(
                'status' => 'success',
                'url' => route('karyawan.index'),
            );
            return $response;
        }
    }

    public function uploadFoto(KaryawanRequest $request, $filename){
        $foto = $request->file('foto_karyawan');
        $ext  = $foto->getClientOriginalExtension();
        if($request->file('foto_karyawan')->isValid()){
            $foto_name = date('YmdHis').'-'.$filename. ".$ext";
            $upload_path = 'foto_karyawan';
            $request->file('foto_karyawan')->move($upload_path, $foto_name);
            return $foto_name;
        }
        return false;
    }

    public function updateFoto($karyawan, KaryawanRequest $request, $filename){
        if($request->hasFile('foto_karyawan')){

            //hapus foto lama jika ada foto baru
            $exist = Storage::disk('foto_karyawan')->exists($karyawan->foto_karyawan);
            if(isset($karyawan->foto_karyawan) && $exist){
                $delete = Storage::disk('foto_karyawan')->delete($karyawan->foto_karyawan);
            }

            //upload foto baru
            $foto = $request->file('foto_karyawan');
            $ext  = $foto->getClientOriginalExtension();
            if($foto->isValid()){
                $foto_name = date('YmdHis').'-'.$filename. ".$ext";
                $upload_path = 'foto_karyawan';
                $foto->move($upload_path, $foto_name);
                return $foto_name;
            }
            
        }
    }

    public function deleteFoto($karyawan){
        $exist = Storage::disk('foto_karyawan')->exists($karyawan->foto_karyawan);
        if($exist){
            Storage::disk('foto_karyawan')->delete($karyawan->foto_karyawan);
        }
    }
}
