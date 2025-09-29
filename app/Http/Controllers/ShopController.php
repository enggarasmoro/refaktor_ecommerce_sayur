<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendInvoice;
use App\Mail\SendNotif;


class ShopController extends Controller
{
    public function index($param = "all")
    {
        $title = 'List Produk';
        $selected_category = null;

        $kategori = DB::table('kategori')->where('status', 1)->get();

        if ($param == "all") {
            $produk = DB::table('produk')
                ->select('produk.*')
                ->where([
                    ['status', '=', '1'],
                    ['stok', '>', '0'],
                ])->orderBy('produk.nama','ASC')->paginate(30);
        } else {
            $cekkategori = DB::table('kategori')->where('slug', $param)->count();
            if ($cekkategori > 0){
                $kategori_data = DB::table('kategori')->where('slug', $param)->first();
                $selected_category = $kategori_data->nama;

                $produk = DB::table('produk')
                    ->join('prod_kategori', 'produk.id', '=', 'prod_kategori.id_produk')
                    ->join('kategori', 'prod_kategori.id_kategori', '=', 'kategori.id')
                    ->select('produk.*')
                    ->where([
                        ['produk.status', '=', '1'],
                        ['stok', '>', '0'],
                        ['kategori.slug', '=', $param],
                    ])->orderBy('produk.nama','ASC')->paginate(30);
            }else{
                $produk = DB::table('produk')
                    ->select('produk.*')
                    ->where([
                        ['status', '=', '1'],
                        ['stok', '>', '0'],
                    ])->orderBy('produk.nama','ASC')->paginate(30);
            }
        }
        return view('frontend.shop.index-modern', compact('title', 'kategori', 'produk', 'selected_category'));
    }

    public function search(Request $request)
    {
        $title = 'Pencarian Produk';
        $selected_category = null;

        $kategori = DB::table('kategori')->where('status', 1)->get();
        $produk = DB::table('produk')
                    ->select('produk.*')
                    ->where([
                        ['status', '=', '1'],
                        ['stok', '>', '0'],
                    ])
                    ->where('nama', 'like', '%'.$request['nama'].'%')
                    ->paginate(30);
        return view('frontend.shop.index-modern', compact('title', 'kategori', 'produk', 'selected_category'));
    }

    public function addcart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_produk' =>  'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $param = $request->all();
        DB::beginTransaction();
        try {
            $produk = DB::table('produk')
                ->where(['id' => $param['id_produk']])->first();
            if (Auth::check()) {
                $cekcartprod = DB::table('cart')
                    ->join('cart_detail', 'cart_detail.id_cart', '=', 'cart.id')
                    ->select(
                        'cart_detail.*'
                    )
                    ->where(['id_user' => Auth::user()->id,'cart_detail.id_produk'=>$param['id_produk']])->first();
            } else {
                $cekcartprod = DB::table('cart')
                    ->join('cart_detail', 'cart_detail.id_cart', '=', 'cart.id')
                    ->select(
                        'cart_detail.*'
                     )
                    ->where(['cart.ipaddress' => $this->getipaddress(),'cart_detail.id_produk'=>$param['id_produk']])->first();
            }
            if($cekcartprod != null){
                if($cekcartprod->qty+1 > $produk->stok){
                    return json_encode(array('status'=>false,'message'=>'Stok Tidak mencukupi'));
                }
            }
            if ($produk->stok >= 1) {
                if (Auth::check()) {
                        $checkcart = DB::table('cart')
                            ->where(['id_user' => Auth::user()->id])->first();
                        if ($checkcart != null) {
                            $checkcart_detail = DB::table('cart_detail')
                                ->where(['id_cart' => $checkcart->id,'id_produk'=>$param['id_produk']])->first();
                            if ($checkcart_detail != null) {
                                $datacartdetail = array(
                                    'id_cart' => $checkcart->id,
                                    'qty' => $checkcart_detail->qty + 1,
                                    'id_produk' => $param['id_produk'],
                                    'harga' => ($produk->harga_diskon == 0)?$produk->harga:$produk->harga_diskon,
                                    'total' => ($produk->harga_diskon == 0)?$produk->harga * ($checkcart_detail->qty + 1):$produk->harga_diskon * ($checkcart_detail->qty + 1),
                                    'created_at' => now(),
                                    'created_by' => Auth::user()->id
                                );
                                DB::table('cart_detail')->where(['id_produk'=>$param['id_produk'],'id_cart'=>$checkcart->id])->update($datacartdetail);
                            } else {
                                $datacartdetail = array(
                                    'id_cart' => $checkcart->id,
                                    'qty' => 1,
                                    'id_produk' => $param['id_produk'],
                                    'harga' => ($produk->harga_diskon == 0)?$produk->harga:$produk->harga_diskon,
                                    'total' => ($produk->harga_diskon == 0)?$produk->harga * 1 :$produk->harga_diskon * 1,
                                    'created_at' => now(),
                                    'created_by' => Auth::user()->id
                                );
                                DB::table('cart_detail')->insert($datacartdetail);
                            }
                        } else {
                            $ipaddress = $this->getipaddress();
                            $datacart = array(
                                'id_user' => Auth::user()->id,
                                'ipaddress' => $ipaddress,
                                'created_at' => now(),
                                'created_by' => Auth::user()->id
                            );
                            DB::table('cart')->insert($datacart);
                            $id = DB::getPDO()->lastInsertId();
                            $datacartdetail = array(
                                'id_cart' => $id,
                                'qty' => 1,
                                'id_produk' => $param['id_produk'],
                                'harga' => ($produk->harga_diskon == 0)?$produk->harga:$produk->harga_diskon,
                                'total' => ($produk->harga_diskon == 0)?$produk->harga * 1:$produk->harga_diskon * 1,
                                'created_at' => now(),
                                'created_by' => Auth::user()->id
                            );
                            DB::table('cart_detail')->insert($datacartdetail);
                        }
                } else {
                    $ipaddress = $this->getipaddress();
                    $checkcart = DB::table('cart')
                            ->where(['ipaddress' => $ipaddress])->first();
                    if ($checkcart != null) {
                        $checkcart_detail = DB::table('cart_detail')
                            ->where(['id_cart' => $checkcart->id,'id_produk'=>$param['id_produk']])->first();
                        if ($checkcart_detail != null) {
                            $datacartdetail = array(
                                'id_cart' => $checkcart->id,
                                'qty' => $checkcart_detail->qty + 1,
                                'id_produk' => $param['id_produk'],
                                'harga' => ($produk->harga_diskon == 0)?$produk->harga:$produk->harga_diskon,
                                'total' => ($produk->harga_diskon == 0)?$produk->harga * ($checkcart_detail->qty + 1) :$produk->harga_diskon * ($checkcart_detail->qty + 1),
                                'created_at' => now(),
                                'created_by' => "Guest"
                            );
                            DB::table('cart_detail')->where(['id_produk'=>$param['id_produk'],'id_cart'=>$checkcart->id])->update($datacartdetail);
                        } else {
                            $datacartdetail = array(
                                'id_cart' => $checkcart->id,
                                'qty' => 1,
                                'id_produk' => $param['id_produk'],
                                'harga' => ($produk->harga_diskon == 0)?$produk->harga:$produk->harga_diskon,
                                'total' => ($produk->harga_diskon == 0)?$produk->harga * 1:$produk->harga_diskon * 1,
                                'created_at' => now(),
                                'created_by' => "Guest"
                            );
                            DB::table('cart_detail')->insert($datacartdetail);
                        }
                    } else {
                        $ipaddress = $this->getipaddress();
                        $datacart = array(
                            'id_user' => "Guest",
                            'ipaddress' => $ipaddress,
                            'created_at' => now(),
                            'created_by' => "Guest"
                        );
                        DB::table('cart')->insert($datacart);
                        $id = DB::getPDO()->lastInsertId();
                        $datacartdetail = array(
                            'id_cart' => $id,
                            'qty' => 1,
                            'id_produk' => $param['id_produk'],
                            'harga' => ($produk->harga_diskon == 0)?$produk->harga:$produk->harga_diskon,
                            'total' => ($produk->harga_diskon == 0)?$produk->harga * 1:$produk->harga_diskon * 1,
                            'created_at' => now(),
                            'created_by' => "Guest"
                        );
                        DB::table('cart_detail')->insert($datacartdetail);
                    }
                }
            } else {
                return json_encode(array('status'=>false,'message'=>'Stok Tidak mencukupi'));
            }
            DB::commit();
            if (Auth::check()) {
                $cart = DB::table('cart')
                    ->where(['id_user' => Auth::user()->id])->first();
            } else {
                $cart = DB::table('cart')
                    ->where(['ipaddress' => $this->getipaddress()])->first();
            }

            if ($cart != null) {
                $cart_detail = DB::table('cart_detail')
                    ->join('produk', 'cart_detail.id_produk', '=', 'produk.id')
                    ->select(
                        'cart_detail.*',
                        'produk.nama as namaproduk',
                        'produk.image',
                        'produk.slug'
                    )
                    ->where(['id_cart' => $cart->id])->get();
            }
            echo json_encode(array('status'=>true,'message'=>'Berhasil menambahkan data ke cart','cart'=>$cart_detail));
        } catch (\Exception $e) {
            DB::rollBack();
            echo json_encode(array('status'=>true,'message'=>'Gagal menambahkan data ke cart silahkan coba lagi'));
        }
    }

    public function removecart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_produk' =>  'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $param = $request->all();
        DB::beginTransaction();
        try {
            $produk = DB::table('produk')
                ->where(['id' => $param['id_produk']])->first();
            if (Auth::check()) {
                $checkcart = DB::table('cart')
                    ->where(['id_user' => Auth::user()->id])->first();
                if ($checkcart != null) {
                    $checkcart_detail = DB::table('cart_detail')
                        ->where(['id_cart' => $checkcart->id,'id_produk'=>$param['id_produk']])->first();
                    if ($checkcart_detail != null) {
                        if ($checkcart_detail->qty > 1) {
                            $datacartdetail = array(
                                'id_cart' => $checkcart->id,
                                'qty' => $checkcart_detail->qty - 1,
                                'id_produk' => $param['id_produk'],
                                'harga' => ($produk->harga_diskon == 0)?$produk->harga:$produk->harga_diskon,
                                'total' => ($produk->harga_diskon == 0)?$produk->harga * ($checkcart_detail->qty - 1):$produk->harga_diskon * ($checkcart_detail->qty - 1),
                                'created_at' => now(),
                                'created_by' => Auth::user()->id
                            );
                            DB::table('cart_detail')->where(['id_produk'=>$param['id_produk'],'id_cart'=>$checkcart->id])->update($datacartdetail);
                        } else {
                            DB::table('cart_detail')->where('id_produk', '=', $param['id_produk'])->where('id_cart','=',$checkcart->id)->delete();
                        }
                    } else {
                        return json_encode(array('status'=>false,'message'=>'Produk Tidak ada dalam cart'));
                    }
                } else {
                    return json_encode(array('status'=>false,'message'=>'Produk Tidak ada dalam cart'));
                }
            } else {
                $ipaddress = $this->getipaddress();
                $checkcart = DB::table('cart')
                        ->where(['ipaddress' => $ipaddress])->first();
                if ($checkcart != null) {
                    $checkcart_detail = DB::table('cart_detail')
                        ->where(['id_cart' => $checkcart->id,'id_produk'=>$param['id_produk']])->first();
                    if ($checkcart_detail != null) {
                        if ($checkcart_detail->qty > 1) {
                            $datacartdetail = array(
                                'id_cart' => $checkcart->id,
                                'qty' => $checkcart_detail->qty - 1,
                                'id_produk' => $param['id_produk'],
                                'harga' => ($produk->harga_diskon == 0)?$produk->harga:$produk->harga_diskon,
                                'total' => ($produk->harga_diskon == 0)?$produk->harga * ($checkcart_detail->qty - 1) :$produk->harga_diskon * ($checkcart_detail->qty - 1),
                                'created_at' => now(),
                                'created_by' => "Guest"
                            );
                            DB::table('cart_detail')->where(['id_produk'=>$param['id_produk'],'id_cart'=>$checkcart->id])->update($datacartdetail);
                        } else {
                            DB::table('cart_detail')->where('id_produk', '=', $param['id_produk'])->where('id_cart','=',$checkcart->id)->delete();
                        }
                    } else {
                        return json_encode(array('status'=>false,'message'=>'Produk Tidak ada dalam cart'));
                    }
                } else {
                        return json_encode(array('status'=>false,'message'=>'Produk Tidak ada dalam cart'));
                }
            }
            DB::commit();
            if (Auth::check()) {
                $cart = DB::table('cart')
                    ->where(['id_user' => Auth::user()->id])->first();
            } else {
                $cart = DB::table('cart')
                    ->where(['ipaddress' => $this->getipaddress()])->first();
            }

            if ($cart != null) {
                $cart_detail = DB::table('cart_detail')
                    ->join('produk', 'cart_detail.id_produk', '=', 'produk.id')
                    ->select(
                        'cart_detail.*',
                        'produk.nama as namaproduk',
                        'produk.image',
                        'produk.slug'
                    )
                    ->where(['id_cart' => $cart->id])->get();
            }
            echo json_encode(array('status'=>true,'message'=>'Berhasil remove produk dari cart','cart'=>$cart_detail));
        } catch (\Exception $e) {
            DB::rollBack();
            return json_encode(array('status'=>false,'message'=>'Gagal menambahkan data ke cart silahkan coba lagi'));
        }
    }

    function getipaddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function mycart()
    {
        $title = 'My Cart';

        if (Auth::check()) {
            $cart = DB::table('cart')
                ->leftjoin('voucher', 'cart.id_voucher', '=', 'voucher.id')
                ->select(
                    'cart.*',
                    'voucher.nominal'
                )
                ->where(['id_user' => Auth::user()->id])->first();
        } else {
            $cart = DB::table('cart')
                ->leftjoin('voucher', 'cart.id_voucher', '=', 'voucher.id')
                ->select(
                    'cart.*',
                    'voucher.nominal'
                )
                ->where(['ipaddress' => $this->getipaddress()])->first();
        }

        if ($cart != null) {
            $cart_detail = DB::table('cart_detail')
                ->join('produk', 'cart_detail.id_produk', '=', 'produk.id')
                ->select(
                    'cart_detail.*',
                    'produk.nama as namaproduk',
                    'produk.stok',
                    'produk.image',
                    'produk.slug'
                )
                ->where(['id_cart' => $cart->id])->get();

            $totalbelanja = DB::table('cart_detail')->where(['id_cart' => $cart->id])->sum('total');
            $ongkir = DB::table('ongkir')
                ->where('min_trans', '<=', $totalbelanja)
                ->where('status', '=', 1)
                ->orderBy('min_trans', 'DESC')->first();
        }

        return view('frontend.shop.mycart', compact('title', 'cart_detail','ongkir','cart'));
    }

    public function editqty(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_produk' =>  'required',
            'qty' =>  'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $param = $request->all();
        DB::beginTransaction();
        try {
            if($param['qty'] <= 0){
                return json_encode(array('status'=>false,'message'=>'Pembelian minimal harus 1 quantity'));
            }
            $produk = DB::table('produk')
                ->where(['id' => $param['id_produk']])->first();
            if ($produk->stok >= $param['qty']) {
                if (Auth::check()) {
                    $checkcart = DB::table('cart')
                        ->where(['id_user' => Auth::user()->id])->first();
                    $checkcart_detail = DB::table('cart_detail')
                         ->where(['id_cart' => $checkcart->id,'id_produk'=>$param['id_produk']])->first();
                    $datacartdetail = array(
                        'qty' => $param['qty'],
                        'total' => $checkcart_detail->harga * $param['qty'],
                    );
                    DB::table('cart_detail')->where(['id_produk'=>$param['id_produk'],'id_cart'=>$checkcart->id])->update($datacartdetail);
                } else {
                    $ipaddress = $this->getipaddress();
                    $checkcart = DB::table('cart')
                            ->where(['ipaddress' => $ipaddress])->first();
                    $checkcart_detail = DB::table('cart_detail')
                            ->where(['id_cart' => $checkcart->id,'id_produk'=>$param['id_produk']])->first();
                    $datacartdetail = array(
                        'qty' => $param['qty'],
                        'total' => $checkcart_detail->harga * $param['qty'],
                    );
                    DB::table('cart_detail')->where(['id_produk'=>$param['id_produk'],'id_cart'=>$checkcart->id])->update($datacartdetail);
                }
            } else {
                return json_encode(array('status'=>false,'message'=>'Stok Tidak mencukupi'));
            }
            DB::commit();
            if (Auth::check()) {
                $cart = DB::table('cart')
                    ->where(['id_user' => Auth::user()->id])->first();
            } else {
                $cart = DB::table('cart')
                    ->where(['ipaddress' => $this->getipaddress()])->first();
            }

            if ($cart != null) {
                $cart_detail = DB::table('cart_detail')
                    ->join('produk', 'cart_detail.id_produk', '=', 'produk.id')
                    ->select(
                        'cart_detail.*',
                        'produk.nama as namaproduk',
                        'produk.image',
                        'produk.slug'
                    )
                    ->where(['id_cart' => $cart->id,'id_produk'=>$param['id_produk']])->first();
                $totalbelanja = DB::table('cart_detail')->where(['id_cart' => $cart->id])->sum('total');
                $ongkir = DB::table('ongkir')
                    ->where('min_trans', '<=', $totalbelanja)
                    ->where('status', '=', 1)
                    ->orderBy('min_trans', 'DESC')->first();
            }
            echo json_encode(array('status'=>true,'message'=>'Berhasil Edit Quantity','cartdetail'=>$cart_detail,'totalbelanja'=>$totalbelanja,'ongkir'=>$ongkir));
        } catch (\Exception $e) {
            DB::rollBack();
            echo json_encode(array('status'=>false,'message'=>'Gagal Edit Quantity silahkan coba lagi'));
        }
    }

    public function deletecart($id)
    {
        DB::beginTransaction();
        try {
            DB::table('cart_detail')->where('id', '=', $id)->delete();
            DB::commit();
            return redirect('/mycart')->with(['success' => 'Berhasil Remove Data']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/mycart')->with(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function check_kupon(Request $request)
    {
        $param = $request->all();
        $this->validate($request, [
            'idcart' =>  'required',
            'kupon' => 'required',
        ]);
        $checkkupon = DB::table('voucher')
                ->where(['nama' => $param['kupon'],'status'=>'1'])->first();

        if(!empty($checkkupon)){
            try {
                $data = [
                    'id_voucher' => $checkkupon->id
                ];
                DB::table('cart')->where('id', '=', $param['idcart'])->update($data);
                return back()
                    ->with('success', 'Kupon Berhasil Ditambahkan.');
            } catch (\Exception $e) {
                return back()
                    ->with('gagal', 'Kupon Tidak Valid.');
            }
        }else{
            return back()
                    ->with('gagal', 'Kupon Tidak Valid.');
        }
    }

    public function checkout()
    {
        $title = "Checkout";
        $kota = DB::table('kota')->get();
        $jamkirim = DB::table('jam_kirim')->where(['status' => 1])->get();
        $package = DB::table('package')->get();
        if (Auth::check()) {
            $cart = DB::table('cart')
                ->where(['id_user' => Auth::user()->id])->first();
        } else {
            $ipaddress = $this->getipaddress();
            $cart = DB::table('cart')
                ->where(['ipaddress' => $ipaddress])->first();
        }

        $bank = DB::table('bank')
                ->where(['status' => 1])->get();

        if ($cart != null) {
            $cart_detail = DB::table('cart_detail')
                ->join('cart', 'cart_detail.id_cart', '=', 'cart.id')
                ->leftjoin('voucher', 'cart.id_voucher', '=', 'voucher.id')
                ->join('produk', 'cart_detail.id_produk', '=', 'produk.id')
                ->select(
                    'cart_detail.*',
                    'voucher.id as idvoucher',
                    'voucher.nominal',
                    'produk.nama as namaproduk',
                    'produk.image',
                    'produk.stok'
                )
                ->where(['id_cart' => $cart->id])->get();

            foreach ($cart_detail as $key => $item) {
                if($item->qty > $item->stok){
                    return redirect('/mycart')->with(['gagal' => 'Stok '.$item->namaproduk.' tidak cukup.Silahkan kurangi quantity produk tersebut.']);
                }
            }
            $totalbelanja = DB::table('cart_detail')->where(['id_cart' => $cart->id])->sum('total');
            $ongkir = DB::table('ongkir')
                ->where('min_trans', '<=', $totalbelanja)
                ->where('status', '=', 1)
                ->orderBy('min_trans', 'DESC')->first();
        }else{
            return redirect('/mycart')->with(['gagal' => 'Silahkan melakukan pembelian barang terlebih dahulu.']);
        }
        return view('frontend.checkout.index', compact('title', 'cart_detail','kota','bank','jamkirim','totalbelanja','ongkir','package'));
    }

    public function addorder(Request $request)
    {
        $param = $request->all();
        $this->validate($request, [
            'idcart' =>  'required',
            'email' => 'required|string|email',
            'nama' =>  'required',
            'nohp' => 'required|string|max:15',
            'kota' => 'required',
            'kodepos' =>  'required',
            'alamat' => 'required',
            'id_bank' =>  'required',
            'jamkirim' => 'required',
            'tgl_kirim' => 'required'
        ]);

        $cart_detail = DB::table('cart_detail')
            ->join('cart', 'cart_detail.id_cart', '=', 'cart.id')
            ->leftjoin('voucher', 'cart.id_voucher', '=', 'voucher.id')
            ->join('produk', 'cart_detail.id_produk', '=', 'produk.id')
            ->select(
                'cart_detail.*',
                'voucher.id as idvoucher',
                'voucher.nominal'
            )
            ->where(['id_cart' => $param['idcart']])->get();
        $kupon = 0;
        if($cart_detail[0]->nominal != null){
            $kupon = $cart_detail[0]->nominal;
        }
        $totalbelanja = DB::table('cart_detail')->where(['id_cart' => $param['idcart']])->sum('total');
        $ongkir = DB::table('ongkir')
                ->where('min_trans', '<=', $totalbelanja)
                ->where('status', '=', 1)
                ->orderBy('min_trans', 'DESC')->first();

        $total = $totalbelanja - $kupon + $ongkir->ongkir + $param['hargaPengemasan'];
        $unique_number = 0;
        if($param['id_bank'] != "COD" ){
            while (1) {
                $unique_number = rand(10, 100);
                $cek_number = DB::table('order')
                    ->where(['created_by' => date('Y-m-d H:i:s'),'total'=>$total,'kode_unik' => $unique_number])->first();
                if (!empty($cek_number)) {
                    continue;
                } else {
                    break;
                }
            }
        }

        //get order_id
        $get_max_id = DB::table('order')->max('id');

        if (!empty($get_max_id)) {
            $get_max_id = substr($get_max_id, -6);
            $get_max_id = $get_max_id + 1;
            $arr_angka = [
                '10' => '00000',
                '100' => '0000',
                '1000' => '000',
                '10000' => '00',
                '100000' => '0',
            ];
            foreach ($arr_angka as $key_angka => $value_angka) {

                if ($get_max_id < $key_angka) {

                    $order_id = 'PS' . date('y') . date('m') . date('d') . $value_angka . $get_max_id;
                    break;
                }
            }
        } else {
            $order_id = 'PS' . date('y') .  date('m') . date('d') . '000001';
        }
        $ipaddress = $this->getipaddress();
        if (Auth::check()) {
            $user = Auth::user()->id;
        }else{
            $user = "Guest";
        }
        DB::beginTransaction();
        try {
            $data = array(
                'id' => $order_id,
                'id_user' => $user,
                'ipaddress' => $ipaddress,
                'nama' => $param['nama'],
                'email' => $param['email'],
                'nohp' => $param['nohp'],
                'alamat' => $param['alamat'],
                'kota' => $param['kota'],
                'kodepos' => $param['kodepos'],
                'id_voucher' => $cart_detail[0]->idvoucher,
                'id_bank' => $param['id_bank'],
                'total' => $total + $unique_number,
                'kode_unik' => $unique_number,
                'ongkir' => $ongkir->ongkir,
                'jamkirim' => $param['jamkirim'],
                'tgl_kirim' => $param['tgl_kirim'],
                'note' => $param['note'],
                'status' => 0,
                'package' => $param['package'],
                'harga_package' => $param['hargaPengemasan'],
                'created_at' => now(),
                'created_by' => $user
            );
            DB::table('order')->insert($data);

            foreach($cart_detail as $key => $valuecart){
                $data = array(
                    'id_order' => $order_id,
                    'qty' => $valuecart->qty,
                    'harga' => $valuecart->harga,
                    'total' => $valuecart->total,
                    'id_produk' => $valuecart->id_produk,
                    'created_at' => now(),
                    'created_by' => $user
                );
                DB::table('order_detail')->insert($data);
                $prod = DB::table('produk')->where('id', $valuecart->id_produk)->first();
                DB::table('produk')->where('id', $valuecart->id_produk)->update(['stok' => $prod->stok - $valuecart->qty]);
            }
            DB::table('cart')->where('id', '=', $param['idcart'])->delete();
            DB::table('cart_detail')->where('id_cart', '=', $param['idcart'])->delete();
            DB::commit();

            $title = 'Instruksi Pembayaran';
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
                ->where(['order.id' => $order_id])->first();

            $orderdetail = DB::table('order_detail')
                ->join('produk', 'order_detail.id_produk', '=', 'produk.id')
                ->select(
                    'order_detail.*',
                    'produk.nama as namaproduk'
                )
                ->where(['order_detail.id_order' => $order_id])->get();

            $data = array(
                "order" => $order,
                "order_detail" => $orderdetail
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('gagal', 'Terjadi Kesalahan saat melakukan checkout.Silahkan hubungi admin.');
        }

        Mail::to($param['email'])->send(new SendInvoice($data));
        Mail::to("paksayursub@gmail.com")->send(new SendNotif($data));
        return view('frontend.checkout.instruksi', compact('title', 'order','orderdetail'));
    }
}
