<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Artisan::call('config:clear');
        $title = 'Home';
        $banner = DB::table('banner')->where('status', 1)->get();
        $kategori = DB::table('kategori')->where('status', 1)->get();

        return view('frontend.home.index', compact('title','banner','kategori'));
    }

    public function getdataproduk($kategori = "all")
    {
        if ($kategori == "all") {
            $produk = DB::table('produk')
                ->select('produk.*')
                ->where([
                    ['status', '=', '1'],
                    ['stok', '>', '0'],
                ])->orderBy('produk.nama','ASC')->get();
        } else {
            // $cekkategori = DB::table('kategori')->where('slug', $param)->count();
            // if ($cekkategori > 0){
            //     $portofolio = DB::table('produk')
            //         ->join('prod_kategori', 'produk.id', '=', 'prod_kategori.id_produk')
            //         ->join('kategori', 'prod_kategori.id_kategori', '=', 'kategori.id')
            //         ->select('produk.*')
            //         ->where([
            //             ['status', '=', '1'],
            //             ['stok', '>', '0'],
            //             ['kategori.sluf', '=', $param],
            //         ])->get();
            // }else{
            //     $produk = DB::table('produk')
            //         ->select('produk.*')
            //         ->where([
            //             ['status', '=', '1'],
            //             ['stok', '>', '0'],
            //         ])->get();
            // }
            $produk = DB::table('produk')
                ->join('prod_kategori', 'produk.id', '=', 'prod_kategori.id_produk')
                ->join('kategori', 'prod_kategori.id_kategori', '=', 'kategori.id')
                ->select('produk.*')
                ->where([
                    ['produk.status', '=', '1'],
                    ['produk.stok', '>', '0'],
                    ['kategori.slug', '=', $kategori],
                ])->orderBy('produk.nama','ASC')->get();
        }
        echo json_encode($produk);
    }

    public function getkategori()
    {
        $kategori = DB::table('kategori')
            ->select('kategori.*')
            ->where([
                ['status', '=', '1'],
            ])->get();

            echo json_encode($kategori);
        }
}
