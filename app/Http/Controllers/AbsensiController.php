<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\JamKerja;
use App\Models\Absensi;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('data-absensi.index');
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
    public function store(Request $request)
    {
        
        setlocale(LC_TIME, 'id_ID');
        Carbon::setLocale('id');
        $hari = Carbon::now()->isoFormat('dddd');
        $jamKerja = JamKerja::where('hari', 'Senin')->first();
        if($jamKerja){
            if($jamKerja->kondisi == 'Libur'){
                echo 'Sekarang Libur!';
            }else{
                $dateNow = Carbon::now()->isoFormat('Y-MM-DD');
                $timeNow = Carbon::now()->toTimeString();
                // $timeNow = '07:07:60';
                $jam_kerja = date("H:i:s", strtotime("$jamKerja->masuk_kerja -1 hours -0 minutes"));

                $cekAbsensi = Absensi::where('tanggal_absen', $dateNow)->where('karyawan_id', $request->karyawan_id)->first();
                
                if($cekAbsensi){
                    $message = "";
                    $status = false;
                //    if($cekAbsensi->waktu_datang == null){
                //        if($timeNow >= $jam_kerja && $timeNow <= $jamKerja->masuk_kerja){
                //            echo 'status tepat waktu';
                //        }else if($timeNow < $jam_kerja){
                //             echo 'absensi belum di buka';
                //        }else{
                //            echo 'status terlambat';
                //        }
                //    }
                    if($cekAbsensi->waktu_pulang == null){
                        if($timeNow >= $jamKerja->pulang_kerja){
                           $message = "Berhasil Absen Pulang";
                           $status = true;
                           $cekAbsensi->update([
                                'waktu_pulang' =>  date("H:i:s", strtotime($timeNow)),
                           ]);
                        }
                        else{
                            $message = "Belum Waktunya Pulang Gus !!!";
                            $status = false;
                        }
                    }else{
                        $message = "Anda Sudah Absensi";
                    }

                    $response = array(
                        'massage' => $message,
                        'status' => $status,
                    );
                    return $response;

                }else{
                    $message = "";
                    $status = false;

                    if($timeNow >= $jam_kerja && $timeNow <= $jamKerja->masuk_kerja){
                        $message = 'status tepat waktu';
                        $status = true;
                        Absensi::create([
                            'jam_kerja_id' => $jamKerja->id,
                            'karyawan_id' => $request->karyawan_id,
                            'tanggal_absen' => $dateNow,
                            'waktu_datang' => date("H:i:s", strtotime($timeNow)),
                            'status' => 'TEPAT_WAKTU'
                        ]);
                    }else if($timeNow < $jam_kerja){
                        $status = false;
                        $message ='absensi belum di buka';
                    }else{
                        $status = true;
                        $message = 'status terlambat';
                        Absensi::create([
                            'jam_kerja_id' => $jamKerja->id,
                            'karyawan_id' => $request->karyawan_id,
                            'tanggal_absen' => $dateNow,
                            'waktu_datang' =>  date("H:i:s", strtotime($timeNow)),
                            'status' => 'TERLAMBAT'
                        ]);
                    }

                    $response = array(
                        'massage' => $message,
                        'status' => $status,
                    );

                    return $response;
                }

            }
        }else{
            $response = array(
                'massage' => 'isi jam kerja terlebih dahulu',
                'status' => false,
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
