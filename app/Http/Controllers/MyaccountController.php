<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;

class MyaccountController extends Controller
{
    public function index()
    {
        $title = 'My Account';
        $order = DB::table('order')
            ->leftjoin('bank', 'order.id_bank', '=', 'bank.id')
            ->leftjoin('users', 'order.id_user', '=', 'users.id')
            ->join('jam_kirim', 'order.jamkirim', '=', 'jam_kirim.id')
            ->join('kota', 'order.kota', '=', 'kota.id')
            ->select('order.*', 'bank.nama as namabank','users.name as namauser','jam_kirim.pengiriman','kota.nama as namakota')
            ->where('order.id_user', Auth::user()->id)->orderBy('created_at', 'asc')->paginate(30);
        return view('frontend.account.index', compact('title','order'));
    }

    public function editprofil(Request $request)
    {
        $param = $request->all();
        $this->validate($request, [
            'name' =>  'required',
            'nohp' => 'required|string|max:12|unique:users,nohp,' . $request->user()->id,
            'email' => 'required|email|string|unique:users,email,' . $request->user()->id,
            'alamat' =>  'required',
            'kodepos' =>  'required',

            // 'image' => 'image|mimes:jpeg,png,jpg|max:3048',
        ]);
        $data = [
            'name' => $param['name'],
            'nohp' => $param['nohp'],
            'email' => $param['email'],
            'alamat' => $param['alamat'],
            'kodepos' => $param['kodepos'],
        ];
        // if ($request->hasFile('image')) {
        //     $filename = Auth::user()->email . '.jpg';
        //     $data['image'] = $filename;
        //     $uploadfoto = $request->file('image')->move('frontend/img/user/', $filename);
        // }
        try {
            DB::table('users')->where('id', '=', Auth::user()->id)->update($data);
            return back()
                ->with('success', 'Update profile berhasil dilakukan.');
        } catch (\Exception $e) {
            return back()
                ->with('gagal', 'Update profile gagal dilakukan.');
        }
    }

    public function detailorder($id)
    {
        $order = DB::table('order')
                ->leftjoin('bank', 'order.id_bank', '=', 'bank.id')
                ->join('kota', 'order.kota', '=', 'kota.id')
                ->leftjoin('voucher', 'order.id_voucher', '=', 'voucher.id')
                ->leftjoin('users', 'order.id_user', '=', 'users.id')
                ->join('jam_kirim', 'order.jamkirim', '=', 'jam_kirim.id')
                ->select(
                    'order.*',
                    'kota.nama as namakota',
                    'voucher.nominal',
                    'voucher.nama as namakupon',
                    'bank.nama as namabank',
                    'bank.norek',
                    'bank.atasnama',
                    'bank.foto','users.name as namauser','jam_kirim.pengiriman'
                )
                ->where(['order.id' => $id])->first();

        $order_detail = DB::table('order_detail')
                ->join('produk', 'order_detail.id_produk', '=', 'produk.id')
                ->select(
                    'order_detail.*',
                    'produk.nama as namaproduk',
                    'produk.image as image'
                )
                ->where(['id_order' => $id])->get();
        return view('frontend.account.modalview', compact('order','order_detail'))->render();
    }
}
