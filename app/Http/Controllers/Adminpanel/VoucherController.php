<?php

namespace App\Http\Controllers\Adminpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Voucher;
use Illuminate\Support\Facades\DB;
use Validator;


class VoucherController extends Controller
{
    public function index()
    {
        $title = 'Config Voucher Diskon';

        return view('backoffice.voucher.index', compact('title'));
    }

    public function getdata()
    {
        $datavoucher = DB::table('voucher')->whereIn('status', [0, 1])->get();
        return response()->json(array('data' => $datavoucher));
    }

    public function showmodal()
    {
        $type = "simpan";
        return view('backoffice.voucher.modal', compact('type'))->render();
    }

    public function showmodaledit($id)
    {
        $type = "edit";
        $voucher = Voucher::find($id);
        return view('backoffice.voucher.modal', compact('type', 'voucher'))->render();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'      =>  'required',
            'nominal'   =>  'required',
            'status'    =>  'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $input = $request->except('_token');
        DB::beginTransaction();
        try {
            $input['created_at'] = now();
            DB::table('voucher')->insert($input);
            DB::commit();
            return response()->json(['success' => 'Berhasil Menambahkan Data Voucher Diskon']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function edit(Request $request)
    {
        $input = $request->except('_token');
        $validator = Validator::make($request->all(), [
            'nama'      =>  'required',
            'nominal'   =>  'required',
            'status'    =>  'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            DB::table('voucher')->where('id', $input['id'])->update($input);
            DB::commit();
            return response()->json(['success' => 'Berhasil Update Data Voucher Diskon']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            DB::table('voucher')->where('id', $id)->delete();
            DB::table('cart')->where('id_voucher', $id)->update(['id_voucher' => NULL]);
            DB::commit();
            return response()->json(['success' => 'Berhasil Delete Data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }
}
