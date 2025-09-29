<?php

namespace App\Http\Controllers\Adminpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kategori;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $title = 'Katgeori Produk';

        return view('backoffice.kategori.index', compact('title'));
    }

    public function getdata()
    {
        $datakategori = DB::table('kategori')->whereIn('status', [0, 1])->get();
        return response()->json(array('data' => $datakategori));
    }

    public function showmodal()
    {
        $type = "simpan";
        return view('backoffice.kategori.modal', compact('type'))->render();
    }

    public function showmodaledit($id)
    {
        $type = "edit";
        $kategori = Kategori::find($id);
        return view('backoffice.kategori.modal', compact('type', 'kategori'))->render();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' =>  'required|unique:kategori',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $input = $request->except('_token');
        DB::beginTransaction();
        try {
            $input['created_at'] = now();
            $input['slug'] = Str::slug($input['nama'], '-');
            DB::table('kategori')->insert($input);
            DB::commit();
            return response()->json(['success' => 'Berhasil Menambahkan Data Kategori Produk']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function edit(Request $request)
    {
        $input = $request->except('_token');
        $validator = Validator::make($request->all(), [
            'nama' =>  'required|unique:kategori,nama,' . $input['id'],
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            $input['updated_at'] = now();
            $input['slug'] = Str::slug($input['nama'], '-');
            DB::table('kategori')->where('id', $input['id'])->update($input);
            DB::commit();
            return response()->json(['success' => 'Berhasil Update Data Kategori Produk']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            DB::table('kategori')->where('id', $id)->update(['status' => 2]);
            DB::commit();
            return response()->json(['success' => 'Berhasil Delete Data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }
}
