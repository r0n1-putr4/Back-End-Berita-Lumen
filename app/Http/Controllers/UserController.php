<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{           

    public function index()
    {
        try {   
            
            $users = User::all();
            return ResponseHelper::successResponse(
                "Data User",
                $users
            );

        } catch (\Exception $e) {
            return ResponseHelper::errorResponse($e->getMessage());
        }
    }

    public function login(Request $request){
        try {

            $validate=$this->validate($request, [
                'username' => 'required',
                'password' => 'required',
            ]);

            $user = User::where('username', $request->username)->where('password', md5($request->password))->first();
            if ($user) {
                return ResponseHelper::successResponse(true,'Login Berhasil',[
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'fullname' => $user->fullname,
                    'gambar' => $user->gambar,
                ]);
            }else{
                return ResponseHelper::errorResponse('Username atau Password Salah');
            }
        }catch (\Exception $e) {
            return ResponseHelper::errorResponse($e->getMessage());
        }
    }

    public function store(Request $request){

        try {

            $validate=$this->validate($request, [
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'fullname' => 'required',
            ]);     
            
            $validate['password'] = md5($request->password);

            $save = User::create($validate);

            return ResponseHelper::successResponse(true,'Data Berhasil Disimpan',$save);

        }catch (\Exception $e) {
            return ResponseHelper::errorResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validate=$this->validate($request, [
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'fullname' => 'required',
            ]);     
            
            $validate['password'] = md5($request->password);    

            $update = User::where('id', $id)->update($validate);

            return ResponseHelper::successResponse(true,'Data Berhasil Diupdate',$update);    

        }catch (\Exception $e) {
            return ResponseHelper::errorResponse($e->getMessage());                      
        }
    }
}