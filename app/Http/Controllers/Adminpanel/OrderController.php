<?php

namespace App\Http\Controllers\Adminpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderProses;
use App\Mail\OrderComplate;

class OrderController extends Controller
{
    public function index()
    {
        $title = 'Daftar Order';

        return view('backoffice.order.index', compact('title'));
    }

    public function getdata($status)
    {
        $dataorder = DB::table('order')
            ->leftjoin('bank', 'order.id_bank', '=', 'bank.id')
            ->leftjoin('users', 'order.id_user', '=', 'users.id')
            ->join('jam_kirim', 'order.jamkirim', '=', 'jam_kirim.id')
            ->join('kota', 'order.kota', '=', 'kota.id')
            ->select('order.*', 'bank.nama as namabank','users.id as namauser','jam_kirim.pengiriman','kota.nama as namakota')
            ->where('order.status', $status)->orderBy('order.created_at', 'DESC')->get();
        return response()->json(array('data' => $dataorder));
    }

    public function showmodalview($id)
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
                ->where(['id_order' => $id])->orderBy('produk.nama','ASC')->get();
        return view('backoffice.order.modalview', compact('order','order_detail'))->render();
    }

    public function showinvoice($id)
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
        return view('backoffice.order.invoice', compact('order','order_detail'));
    }

    public function cancelorder($id)
    {
        DB::beginTransaction();
        try {
            DB::table('order')->where('id', $id)->update(['status' => 3,'updated_at'=>now(),'updated_by'=>Auth::guard('admin')->user()->id]);
            $cart_detail = DB::table('order_detail')->where(['id_order' => $id])->get();
            foreach($cart_detail as $key => $valuecart){
                $prod = DB::table('produk')->where('id', $valuecart->id_produk)->first();
                DB::table('produk')->where('id', $valuecart->id_produk)->update(['stok' => $prod->stok + $valuecart->qty]);
            }
            DB::commit();
            return response()->json(['success' => 'Berhasil Camcel Order']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function confirmorder($id)
    {
        DB::beginTransaction();
        try {
            DB::table('order')->where('id', $id)->update(['status' => 1,'updated_at'=>now(),'updated_by'=>Auth::guard('admin')->user()->id]);
            DB::commit();
            $order = DB::table('order')
                ->leftjoin('bank', 'order.id_bank', '=', 'bank.id')
                ->join('kota', 'order.kota', '=', 'kota.id')
                ->join('jam_kirim', 'order.jamkirim', '=', 'jam_kirim.id')
                ->leftjoin('voucher', 'order.id_voucher', '=', 'voucher.id')
                ->select(
                    'order.*',
                    'voucher.nominal',
                    'bank.nama as namabank',
                    'bank.norek',
                    'bank.atasnama',
                    'bank.foto',
                    'kota.nama as namakota',
                    'jam_kirim.pengiriman'
                )
                ->where(['order.id' => $id])->first();
            
            $orderdetail = DB::table('order_detail')
                ->join('produk', 'order_detail.id_produk', '=', 'produk.id')
                ->select(
                    'order_detail.*',
                    'produk.nama as namaproduk'
                )
                ->where(['order_detail.id_order' => $id])->get();

            $data = array(
                "order" => $order,
                "order_detail" => $orderdetail
            );
            Mail::to($order->email)->send(new OrderProses($data));

            return response()->json(['success' => 'Berhasil Confirm Order']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function completeorder($id)
    {
        DB::beginTransaction();
        try {
            DB::table('order')->where('id', $id)->update(['status' => 2,'updated_at'=>now(),'updated_by'=>Auth::guard('admin')->user()->id]);
            DB::commit();
            $order = DB::table('order')
                ->leftjoin('bank', 'order.id_bank', '=', 'bank.id')
                ->join('kota', 'order.kota', '=', 'kota.id')
                ->join('jam_kirim', 'order.jamkirim', '=', 'jam_kirim.id')
                ->leftjoin('voucher', 'order.id_voucher', '=', 'voucher.id')
                ->select(
                    'order.*',
                    'voucher.nominal',
                    'bank.nama as namabank',
                    'bank.norek',
                    'bank.atasnama',
                    'bank.foto',
                    'kota.nama as namakota',
                    'jam_kirim.pengiriman'
                )
                ->where(['order.id' => $id])->first();
            
            $orderdetail = DB::table('order_detail')
                ->join('produk', 'order_detail.id_produk', '=', 'produk.id')
                ->select(
                    'order_detail.*',
                    'produk.nama as namaproduk'
                )
                ->where(['order_detail.id_order' => $id])->get();

            $data = array(
                "order" => $order,
                "order_detail" => $orderdetail
            );
            Mail::to($order->email)->send(new OrderComplate($data));
            return response()->json(['success' => 'Berhasil Complate Order']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function onhold($id)
    {
        DB::beginTransaction();
        try {
            DB::table('order')->where('id', $id)->update(['status' => 0,'updated_at'=>now(),'updated_by'=>Auth::guard('admin')->user()->id]);
            DB::commit();
            return response()->json(['success' => 'Berhasil Ubah Status Menjadi onhold']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function onholdfromcancel($id)
    {
        DB::beginTransaction();
        try {
            DB::table('order')->where('id', $id)->update(['status' => 0,'updated_at'=>now(),'updated_by'=>Auth::guard('admin')->user()->id]);
            $cart_detail = DB::table('order_detail')->where(['id_order' => $id])->get();
            foreach($cart_detail as $key => $valuecart){
                $prod = DB::table('produk')->where('id', $valuecart->id_produk)->first();
                DB::table('produk')->where('id', $valuecart->id_produk)->update(['stok' => $prod->stok - $valuecart->qty]);
            }
            DB::commit();
            return response()->json(['success' => 'Berhasil Ubah Status Menjadi onhold']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function showmodaledit($id)
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
        $produk = DB::table('produk')
            ->select('produk.*')
            ->where(['status'=>1])->get();

        $kota = DB::table('kota')->where(['status'=>1])->get();
        $jamkirim = DB::table('jam_kirim')->where(['status'=>1])->get();
        $bank = DB::table('bank')->where(['status'=>1])->get();

        return view('backoffice.order.modaledit', compact('order','order_detail','produk','kota','jamkirim','bank'))->render();
    }

    public function editqty(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' =>  'required',
            'idproduk' =>  'required',
            'qty' =>  'required',
            'idcart' =>  'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $param = $request->all();
        DB::beginTransaction();
        try {
            $produk = DB::table('produk')
                ->where(['id' => $param['idproduk']])->first();
            if ($produk->stok >= $param['qty']) {
                $order_detail = DB::table('order_detail')
                            ->where(['id' => $param['id']])->first();
                $datacartdetail = array(
                    'qty' => $param['qty'],
                    'total' => $order_detail->harga * $param['qty'],
                );
                DB::table('order_detail')->where(['id'=>$param['id']])->update($datacartdetail);
                
                $totalbelanja = DB::table('order_detail')
                            ->where(['id_order' => $param['idcart']])->sum('total');
                $ongkir = DB::table('ongkir')
                    ->where('min_trans', '<=', $totalbelanja)
                    ->where('status', '=', 1)
                    ->orderBy('min_trans', 'DESC')->first();
                $voucher = DB::table('order')
                    ->leftjoin('voucher', 'order.id_voucher', '=', 'voucher.id')
                    ->select(
                        'order.*',
                        'voucher.nominal'
                    )
                    ->where(['order.id' => $param['idcart']])->first();
                $nominal_voucher = ($voucher->id_voucher == null)?0:$voucher->nominal;
                $totalorder = $totalbelanja + $voucher->kode_unik + $ongkir->ongkir - $nominal_voucher;
                $dataorder = array(
                    'total' => $totalorder,
                    'ongkir' => $ongkir->ongkir
                );
                DB::table('order')->where(['id'=>$param['idcart']])->update($dataorder);
            } else {
                return response()->json(['errors' => 'Stok Tidak mencukupi']);
            }            
            DB::commit();
            return response()->json(['success' => 'Berhasil Edit Order']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Stok Tidak mencukupi']);
        }
    }

    public function remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' =>  'required',
            'idcart' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $param = $request->all();
        DB::beginTransaction();
        try {
            $countorder = DB::table('order_detail')
                ->where(['id_order' => $param['idcart']])->count();
            if ($countorder > 1) {
                DB::table('order_detail')->where('id', '=', $param['id'])->delete();
                $totalbelanja = DB::table('order_detail')
                            ->where(['id_order' => $param['idcart']])->sum('total');
                $ongkir = DB::table('ongkir')
                    ->where('min_trans', '<=', $totalbelanja)
                    ->where('status', '=', 1)
                    ->orderBy('min_trans', 'DESC')->first();
                $voucher = DB::table('order')
                    ->leftjoin('voucher', 'order.id_voucher', '=', 'voucher.id')
                    ->select(
                        'order.*',
                        'voucher.nominal'
                    )
                    ->where(['order.id' => $param['idcart']])->first();
                $nominal_voucher = ($voucher->id_voucher == null)?0:$voucher->nominal;
                $totalorder = $totalbelanja + $voucher->kode_unik + $ongkir->ongkir - $nominal_voucher;
                $dataorder = array(
                    'total' => $totalorder,
                    'ongkir' => $ongkir->ongkir
                );
                DB::table('order')->where(['id'=>$param['idcart']])->update($dataorder);
            } else {
                DB::table('order')->where('id', '=', $param['idcart'])->delete();
                DB::table('order_detail')->where('id', '=', $param['id'])->delete();
            }            
            DB::commit();
            return response()->json(['success' => 'Berhasil Edit Order']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Gagal Remove order detail']);
        }
    }

    public function addproduk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' =>  'required',
            'id_produk' =>  'required',
            'qty' =>  'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $param = $request->all();
        DB::beginTransaction();
        try {
            $produk = DB::table('produk')
                ->where(['id' => $param['id_produk']])->first();
            if ($produk->stok >= $param['qty']) {
                $datacartdetail = array(
                    'id_order' => $param['id'],
                    'qty' => $param['qty'],
                    'harga' => ($produk->harga_diskon == 0)?$produk->harga:$produk->harga_diskon,
                    'total' => ($produk->harga_diskon == 0)?$produk->harga * $param['qty'] :$produk->harga_diskon * $param['qty'],
                    'id_produk' => $param['id_produk'],
                    'created_at' => now(),
                    'created_by' => Auth::guard('admin')->user()->id
                );
                DB::table('order_detail')->insert($datacartdetail);
                
                $totalbelanja = DB::table('order_detail')
                            ->where(['id_order' => $param['id']])->sum('total');
                $ongkir = DB::table('ongkir')
                    ->where('min_trans', '<=', $totalbelanja)
                    ->where('status', '=', 1)
                    ->orderBy('min_trans', 'DESC')->first();
                $voucher = DB::table('order')
                    ->leftjoin('voucher', 'order.id_voucher', '=', 'voucher.id')
                    ->select(
                        'order.*',
                        'voucher.nominal'
                    )
                    ->where(['order.id' => $param['id']])->first();
                $nominal_voucher = ($voucher->id_voucher == null)?0:$voucher->nominal;
                $totalorder = $totalbelanja + $voucher->kode_unik + $ongkir->ongkir - $nominal_voucher;
                $dataorder = array(
                    'total' => $totalorder,
                    'ongkir' => $ongkir->ongkir
                );
                DB::table('order')->where(['id'=>$param['id']])->update($dataorder);
            } else {
                return response()->json(['errors' => 'Stok Tidak mencukupi']);
            }            
            DB::commit();
            return response()->json(['success' => 'Berhasil Edit Order']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Stok Tidak mencukupi']);
        }
    }

    public function exportlaporan($date = null)
    {
        if ($date == null){
            $date = date("Y-m-d"). " - " .date("Y-m-d");
        }
        return Excel::download(new LaporanExport($date), 'export.xlsx');
    }

    public function editorder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' =>  'required',
            'email' => 'required|string|email',
            'nama' =>  'required',
            'nohp' => 'required|string|max:12',
            'kota' => 'required',
            'kodepos' =>  'required',
            'alamat' => 'required',
            'id_bank' =>  'required',
            'jamkirim' => 'required',
            'tgl_kirim' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $param = $request->all();
        DB::beginTransaction();
        try {
            $data = array(
                'nama' => $param['nama'],
                'email' => $param['email'],
                'nohp' => $param['nohp'],
                'alamat' => $param['alamat'],
                'kota' => $param['kota'],
                'kodepos' => $param['kodepos'],
                'id_bank' => $param['id_bank'],
                'jamkirim' => $param['jamkirim'],
                'tgl_kirim' => $param['tgl_kirim'],
                'updated_at' => now(),
                'updated_by' => Auth::guard('admin')->user()->id
            );
            DB::table('order')->where(['id'=>$param['id']])->update($data);
            DB::commit();
            return response()->json(['success' => 'Berhasil Edit Order']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Edit order gagal di lakukan']);
        }
    }
}
