<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $payload = $request->all();
        $payload['password'] = \Hash::make($payload['password']);
        User::create($payload);
        if($request->ajax()){
            \Session::flash('success','Data User Berhasil Di Simpan');
            $response = array(
                'status' => 'success',
                'url' => route('users.index'),
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
        $users = User::findOrFail($id);
        $payload = $request->all();
        if($request->filled('password')){
            $payload['password'] = \Hash::make($payload['password']);
        }else{
            $payload['password'] = $users->password;
        }

        if($request->ajax()){
            $users->update($payload);
            \Session::flash('success','Data User Berhasil Di Update');
            $response = array(
                'status' => 'success',
                'url' => route('users.index'),
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
        $users =  User::findOrFail($id);
    
        if($users->delete()){
            \Session::flash('success','Data User Berhasil Di Hapus');
            $response = array(
                'status' => 'success',
                'url' => route('users.index'),
            );
            return $response;
        }

    }
}
