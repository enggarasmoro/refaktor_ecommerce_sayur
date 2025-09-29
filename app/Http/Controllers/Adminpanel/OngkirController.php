<?php

namespace App\Http\Controllers\Adminpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ongkir;
use Illuminate\Support\Facades\DB;
use Validator;

class OngkirController extends Controller
{
    public function index()
    {
        $title = 'Ongkir';

        return view('backoffice.ongkir.index', compact('title'));
    }

    public function getdata()
    {
        $ongkir = DB::table('ongkir')->whereIn('status', [0, 1])->get();
        return response()->json(array('data' => $ongkir));
    }

    public function showmodal()
    {
        $type = "simpan";
        return view('backoffice.ongkir.modal', compact('type'))->render();
    }

    public function showmodaledit($id)
    {
        $type = "edit";
        $ongkir = Ongkir::find($id);
        return view('backoffice.ongkir.modal', compact('type', 'ongkir'))->render();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'min_trans' =>  'required',
            'ongkir' =>  'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $input = $request->except('_token');
        DB::beginTransaction();
        try {
            $input['created_at'] = now();
            DB::table('ongkir')->insert($input);
            DB::commit();
            return response()->json(['success' => 'Berhasil Menambahkan Data Ongkir']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function edit(Request $request)
    {
        $input = $request->except('_token');
        $validator = Validator::make($request->all(), [
            'min_trans' =>  'required',
            'ongkir' =>  'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            $input['updated_at'] = now();
            DB::table('ongkir')->where('id', $input['id'])->update($input);
            DB::commit();
            return response()->json(['success' => 'Berhasil Update Data Ongkir']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            DB::table('ongkir')->where('id', $id)->update(['status' => 2]);
            DB::commit();
            return response()->json(['success' => 'Berhasil Delete Data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }
}
