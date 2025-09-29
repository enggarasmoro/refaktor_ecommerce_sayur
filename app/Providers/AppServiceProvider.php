<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use App\Kategori;
use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['layouts.frontend.header', 'layouts.frontend.header-modern'], function ($view) {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            if (Auth::check()) {
                $cart = DB::table('cart')
                    ->where(['id_user' => Auth::user()->id])->first();
            } else {
                $cart = DB::table('cart')
                    ->where(['ipaddress' => $ip])->first();
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
                $view->with('cart_detail', $cart_detail);
            }

            $pengiriman = DB::table('jam_kirim')
                    ->where(['status' => 1])->get();

            $newslatter = DB::table('newslatter')->where('status',  '1')->first();
            $view->with('pengiriman', $pengiriman);
            $view->with('cart', $cart);
            $view->with('newslatter', $newslatter);
        });

        view()->composer(['layouts.frontend.header', 'layouts.frontend.header-modern'], function ($view) {
            $kategori = Kategori::where('status', 1)->get();
            $view->with('kategori', $kategori);
        });
    }
}
