<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Produk;
use App\ProductMedia;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        if (!DB::table('kategori')->exists()) {
            $this->command->warn('No kategori records found. Seed categories first to link products.');
            return;
        }

    $kategoriId = DB::table('kategori')->value('id');

        for ($i=0; $i<40; $i++) {
            $harga = random_int(10000,150000);
            $discountPercent = [null,5,10,15,20,25,30][array_rand([0,1,2,3,4,5,6])];
            $video = (random_int(1,100) <= 12);

            $withSpecHtml = random_int(1,100) <= 50; // 50% products have rich spec html

            $data = [
                'nama' => 'Produk '.$i,
                'info' => 'Deskripsi singkat produk '.$i,
                'harga' => $harga,
                'harga_diskon' => $harga,
                'status' => 1,
                'slug' => 'produk-'.$i,
                'description' => 'Ini adalah deskripsi lengkap untuk Produk '.$i.".\nBahan segar pilihan dikemas higienis.",
                'origin' => ['Lokal','Impor','Bandung','Bogor'][array_rand(['a','b','c','d'])],
                'brochure_image' => null,
                'spec_html' => $withSpecHtml ? '<ul><li><strong>Berat:</strong> '.random_int(1,5).' kg</li><li><strong>Asal:</strong> '.(['Lokal','Impor'][array_rand(['x','y'])]).'</li><li><strong>Kualitas:</strong> Grade A</li></ul>' : null,
            ];
            if (Schema::hasColumn('produk','id_kategori')) {
                $data['id_kategori'] = $kategoriId;
            }
            if (Schema::hasColumn('produk','discount_percent')) {
                $data['discount_percent'] = $discountPercent;
            }
            if (Schema::hasColumn('produk','stok')) {
                $data['stok'] = random_int(0,100);
            }
            $produk = Produk::create($data);

            // Always ensure at least one media (position 0)
            ProductMedia::create([
                'produk_id' => $produk->id,
                'type' => 'image',
                'url' => 'https://picsum.photos/seed/prodmain'.$i.'/600/600',
                'position' => 0,
            ]);
            // Additional gallery items
            $galleryCount = random_int(0,2);
            for ($m=1; $m<=$galleryCount; $m++) {
                ProductMedia::create([
                    'produk_id' => $produk->id,
                    'type' => 'image',
                    'url' => 'https://picsum.photos/seed/prodg'.$i.'_'.$m.'/600/600',
                    'position' => $m,
                ]);
            }
        }
    }
}
