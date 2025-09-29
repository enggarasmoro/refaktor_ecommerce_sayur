<?php

namespace App\Http\Controllers\Adminpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Produk;
use Illuminate\Support\Facades\DB;
use Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;


class ProdukController extends Controller
{
    public function index()
    {
        $title = 'Produk';

        return view('backoffice.produk.index', compact('title'));
    }

    public function getdata()
    {
        $produk = DB::table('produk')
            ->select('produk.*')
            ->whereIn('produk.status', [0, 1])->get();
        return response()->json(array('data' => $produk));
    }

    public function showmodal()
    {
        $type = "simpan";
        $kategori = DB::table('kategori')->where('status', 1)->get();
        $produk_kategori = array();
        return view('backoffice.produk.modal', compact('type', 'kategori','produk_kategori'))->render();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' =>  'required|unique:produk',
            'harga' =>  'required|integer',
            // 'info' =>  'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
            'status' => 'required',
            // 'stok' =>  'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $input = $request->except('_token');
        DB::beginTransaction();
        try {
            $dataproduk = array(
                'nama' => $input['nama'],
                'stok' => ($input['stok'] == null)?0:$input['stok'],
                'harga' => $input['harga'],
                'harga_diskon' => ($input['harga_diskon'] == null)? 0 : $input['harga_diskon'],
                'info' => $input['info'],
                'slug' => Str::slug($input['nama'], '-'),
                'status' => $input['status'],
                'created_at' => now()
            );

            if ($request->hasFile('image')) {
                $filename = Str::slug($input['nama'], '-') . '.jpg';
                $dataproduk['image'] = 'images/products/'.$filename;
                // $canvas = Image::canvas(900, 900);
                $resizeImage  = Image::make($request->file('image'))->resize(300, 300, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resizeImage->insert($resizeImage, 'center');
                $resizeImage->save('frontend/images/products/' . $filename);
            }
            DB::table('produk')->insert($dataproduk);
            $id = DB::getPDO()->lastInsertId();
            foreach ($input['id_kategori'] as $key => $value) {
                $datakategori = array(
                    'id_produk' => $id,
                    'id_kategori' => $value,
                );
                DB::table('prod_kategori')->insert($datakategori);
            }
            DB::commit();
            return response()->json(['success' => 'Berhasil Menambahkan Data Produk']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function showmodaledit($id)
    {
        $type = "edit";
        $produk = Produk::find($id);
        $kategori = DB::table('kategori')->where('status', 1)->get();
        $prod_kategori = DB::table('prod_kategori')->where('id_produk', $id)->get();
        $produk_kategori = array();
        foreach ($prod_kategori as $key => $value) {
            array_push($produk_kategori,$value->id_kategori);
        }
        return view('backoffice.produk.modal', compact('type', 'produk', 'kategori','produk_kategori'))->render();
    }

    public function edit(Request $request)
    {
        $input = $request->except('_token');
        $validator = Validator::make($request->all(), [
            'nama' =>  'required|unique:produk,nama,' . $input['id'],
            // 'stok' =>  'required',
            'harga' =>  'required|integer',
            // 'info' =>  'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:5048',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $dataproduk = array(
                'nama' => $input['nama'],
                'stok' => ($input['stok'] == null)?0:$input['stok'],
                'harga' => $input['harga'],
                'harga_diskon' => ($input['harga_diskon'] == null)? 0 : $input['harga_diskon'],
                'info' => $input['info'],
                'slug' => Str::slug($input['nama'], '-'),
                'status' => $input['status'],
                'updated_at' => now()
            );
            $gambar = DB::table('produk')->where('id', $input['id'])->first();
            if ($request->hasFile('image')) {
                $filename = Str::slug($input['nama'], '-') .date('YmdHis').'.jpg';
                unlink('/home/u937293872/domains/paksayur.com/public_html/frontend/'.$gambar->image);
                $dataproduk['image'] = 'images/products/'.$filename;
                // $canvas = Image::canvas(900, 900);
                $resizeImage  = Image::make($request->file('image'))->resize(300, 300, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resizeImage->insert($resizeImage, 'center');
                $resizeImage->save('frontend/images/products/' . $filename);
            }

            DB::table('produk')->where('id', $input['id'])->update($dataproduk);
            DB::table('prod_kategori')->where('id_produk', '=', $input['id'])->delete();
            foreach ($input['id_kategori'] as $key => $value) {
                $datakategori = array(
                    'id_produk' => $input['id'],
                    'id_kategori' => $value,
                );
                DB::table('prod_kategori')->insert($datakategori);
            }
            DB::commit();
            return response()->json(['success' => 'Berhasil Update Data Produk']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            DB::table('produk')->where('id', '=', $id)->delete();
            DB::table('prod_kategori')->where('id_produk', '=', $id)->delete();
            DB::table('cart_detail')->where('id_produk', '=', $id)->delete();
            DB::commit();
            return response()->json(['success' => 'Berhasil Delete Data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }
}
