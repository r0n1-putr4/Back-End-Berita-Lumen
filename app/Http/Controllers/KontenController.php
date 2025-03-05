<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;

class KontenController extends Controller
{
    public function index(Request $request)
    {
        try {

            $kontens = Konten::where('judul', 'like', '%' . $request->judul . '%')->get();
            $success = false;
            $message = "";
            if (count($kontens) == 0) {
                $success = false;
                $message = "Data Kosong";
            } else {
                $success = true;
                $message = "Data Berhasil Konten Berita";
            }

            return ResponseHelper::successResponse(
                $success,
                $message,
                $kontens
            );
        } catch (\Exception $e) {
            return ResponseHelper::errorResponse($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {

            $validate = $this->validate($request, [
                'judul' => 'required',
                'isi' => 'required',
                'gambar' => 'required|image|file|max:1024'
            ]);

            $validate['gambar'] = $request->file('gambar')->store('images');

            $save = Konten::create($validate);

            return ResponseHelper::successResponse(
                true,
                "Data Berhasil Disimpan",
                $save
            );
        } catch (\Exception $e) {
            return ResponseHelper::errorResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
           

        try {

            $konten = Konten::find($id);
            if (!$konten) {
                return ResponseHelper::errorResponse('Data tidak ditemukan');
            }
            $delete = Konten::destroy($id);
            if ($delete) {
                return ResponseHelper::successResponse(
                    true,
                    "Data Berhasil Dihapus",
                );
            } 
        } catch (\Exception $e) {
            return ResponseHelper::errorResponse($e->getMessage());          
            
        }
    }
}
