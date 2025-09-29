<?php

namespace App\Http\Controllers;

use App\Banner;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function addTestBanners()
    {
        // Clear existing banners
        Banner::truncate();

        // Add sample banners
        $banners = [
            [
                'name' => 'DISKON HINGGA 75RB - PENGGUNA BARU!',
                'image' => 'https://via.placeholder.com/375x200/00b894/ffffff?text=DISKON+75RB',
                'status' => '1'
            ],
            [
                'name' => 'FLASH SALE 50% OFF',
                'image' => 'https://via.placeholder.com/375x200/e17055/ffffff?text=FLASH+SALE',
                'status' => '1'
            ],
            [
                'name' => 'WEEKEND SPECIAL DEALS',
                'image' => 'https://via.placeholder.com/375x200/74b9ff/ffffff?text=WEEKEND+DEALS',
                'status' => '1'
            ],
            [
                'name' => 'PROMO GAJIAN BULAN INI',
                'image' => 'https://via.placeholder.com/375x200/fd79a8/ffffff?text=PROMO+GAJIAN',
                'status' => '1'
            ]
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }

        return response()->json([
            'message' => 'Test banners added successfully!',
            'banners' => Banner::all()
        ]);
    }
}
