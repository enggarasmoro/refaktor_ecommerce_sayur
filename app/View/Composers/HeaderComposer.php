<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HeaderComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Get categories for navigation
        $kategori = DB::table('kategori')->where('status', 1)->get();

        // Get cart details for cart dropdown
        $cart_detail = null;
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $cart_detail = DB::table('cart')
                ->join('produk', 'cart.id_produk', '=', 'produk.id')
                ->select('cart.*', 'produk.nama as namaproduk', 'produk.image')
                ->where('cart.session_id', $cart)
                ->get();
        }

        // Share data with the view
        $view->with([
            'kategori' => $kategori,
            'cart_detail' => $cart_detail
        ]);
    }
}
