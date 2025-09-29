<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Kategori;

class KategoriController extends Controller
{
    public function __construct(private CategoryService $service) {}

    public function getMobileKategori()
    {
        return response()->json($this->service->mobileList());
    }

    public function addTestKategori()
    {
        // Clear existing categories
    \App\Kategori::truncate();

        // Add sample categories dengan gambar, icon, dan warna
        $categories = [
            ['nama' => 'Sayuran', 'gambar' => 'https://via.placeholder.com/80x80/96CEB4/ffffff?text=🥗', 'icon_emoji' => '🥗', 'warna' => '#96CEB4'],
            ['nama' => 'Buah-buahan', 'gambar' => 'https://via.placeholder.com/80x80/FF6B6B/ffffff?text=🍎', 'icon_emoji' => '🍎', 'warna' => '#FF6B6B'],
            ['nama' => 'Daging', 'gambar' => 'https://via.placeholder.com/80x80/FF8E53/ffffff?text=🥩', 'icon_emoji' => '🥩', 'warna' => '#FF8E53'],
            ['nama' => 'Seafood', 'gambar' => 'https://via.placeholder.com/80x80/81ECEC/ffffff?text=🐟', 'icon_emoji' => '🐟', 'warna' => '#81ECEC'],
            ['nama' => 'Susu & Dairy', 'gambar' => 'https://via.placeholder.com/80x80/FFEAA7/ffffff?text=🥛', 'icon_emoji' => '🥛', 'warna' => '#FFEAA7'],
            ['nama' => 'Roti & Kue', 'gambar' => 'https://via.placeholder.com/80x80/FD79A8/ffffff?text=🍞', 'icon_emoji' => '🍞', 'warna' => '#FD79A8'],
            ['nama' => 'Minuman', 'gambar' => 'https://via.placeholder.com/80x80/74B9FF/ffffff?text=🥤', 'icon_emoji' => '🥤', 'warna' => '#74B9FF'],
            ['nama' => 'Snack', 'gambar' => 'https://via.placeholder.com/80x80/FDCB6E/ffffff?text=🍿', 'icon_emoji' => '🍿', 'warna' => '#FDCB6E'],
            ['nama' => 'Bumbu Dapur', 'gambar' => 'https://via.placeholder.com/80x80/A29BFE/ffffff?text=🧄', 'icon_emoji' => '🧄', 'warna' => '#A29BFE'],
            ['nama' => 'Frozen Food', 'gambar' => 'https://via.placeholder.com/80x80/DDA0DD/ffffff?text=❄️', 'icon_emoji' => '❄️', 'warna' => '#DDA0DD'],
            ['nama' => 'Pesta Gajian', 'gambar' => 'https://via.placeholder.com/80x80/FF6B6B/ffffff?text=🎉', 'icon_emoji' => '🎉', 'warna' => '#FF6B6B'],
            ['nama' => 'Kolaborasi', 'gambar' => 'https://via.placeholder.com/80x80/4ECDC4/ffffff?text=🤝', 'icon_emoji' => '🤝', 'warna' => '#4ECDC4'],
            ['nama' => 'Protein', 'gambar' => 'https://via.placeholder.com/80x80/96CEB4/ffffff?text=🍖', 'icon_emoji' => '🍖', 'warna' => '#96CEB4'],
            ['nama' => 'Steak', 'gambar' => 'https://via.placeholder.com/80x80/FF7675/ffffff?text=🥩', 'icon_emoji' => '🥩', 'warna' => '#FF7675'],
            ['nama' => 'Segari\'s Kitchen', 'gambar' => 'https://via.placeholder.com/80x80/74B9FF/ffffff?text=👨‍🍳', 'icon_emoji' => '👨‍🍳', 'warna' => '#74B9FF'],
            ['nama' => 'Unggas', 'gambar' => 'https://via.placeholder.com/80x80/FDCB6E/ffffff?text=🐔', 'icon_emoji' => '🐔', 'warna' => '#FDCB6E'],
            ['nama' => 'Produk Beku', 'gambar' => 'https://via.placeholder.com/80x80/A29BFE/ffffff?text=❄️', 'icon_emoji' => '❄️', 'warna' => '#A29BFE'],
            ['nama' => 'Bakery & Sarapan', 'gambar' => 'https://via.placeholder.com/80x80/FD79A8/ffffff?text=🥐', 'icon_emoji' => '🥐', 'warna' => '#FD79A8'],
            ['nama' => 'Hotpot', 'gambar' => 'https://via.placeholder.com/80x80/FDCB6E/ffffff?text=🍲', 'icon_emoji' => '🍲', 'warna' => '#FDCB6E'],
            ['nama' => 'Japanese BBQ', 'gambar' => 'https://via.placeholder.com/80x80/E84393/ffffff?text=🍖', 'icon_emoji' => '🍖', 'warna' => '#E84393']
        ];

        foreach ($categories as $category) {
            Kategori::create([
                'nama' => $category['nama'],
                'gambar' => $category['gambar'],
                'icon_emoji' => $category['icon_emoji'],
                'warna' => $category['warna'],
                'status' => '1'
            ]);
        }

        return response()->json([
            'message' => 'Test categories added successfully!',
            'categories' => Kategori::all()
        ]);
    }
}
