<?php

namespace App\Http\Controllers\Adminpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\JamKirim;
use Illuminate\Support\Facades\DB;
use Validator;

class JamkirimController extends Controller
{
    public function index()
    {
        $title = 'Jam Kirim';

        return view('backoffice.jamkirim.index', compact('title'));
    }

    public function getdata()
    {
        $jamkirim = DB::table('jam_kirim')->whereIn('status', [0, 1])->get();
        return response()->json(array('data' => $jamkirim));
    }

    public function showmodal()
    {
        $type = "simpan";
        return view('backoffice.jamkirim.modal', compact('type'))->render();
    }

    public function showmodaledit($id)
    {
        $type = "edit";
        $jamkirim = JamKirim::find($id);
        return view('backoffice.jamkirim.modal', compact('type', 'jamkirim'))->render();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengiriman' =>  'required',
            'jam_kirim'  => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $input = $request->except('_token');
        DB::beginTransaction();
        try {
            $input['created_at'] = now();
            DB::table('jam_kirim')->insert($input);
            DB::commit();
            return response()->json(['success' => 'Berhasil Menambahkan Data jam kirim']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function edit(Request $request)
    {
        $input = $request->except('_token');
        $validator = Validator::make($request->all(), [
            'pengiriman' =>  'required',
            'jam_kirim'  => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            $input['updated_at'] = now();
            DB::table('jam_kirim')->where('id', $input['id'])->update($input);
            DB::commit();
            return response()->json(['success' => 'Berhasil Update Data jam kirim']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            DB::table('jam_kirim')->where('id', $id)->update(['status' => 2]);
            DB::commit();
            return response()->json(['success' => 'Berhasil Delete Data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }
}
