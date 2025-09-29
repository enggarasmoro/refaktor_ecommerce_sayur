<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Produk;

class ProdukEnrichmentSeeder extends Seeder
{
    public function run(): void
    {
        $fakerOrigins = ['Lokal','Bogor','Bandung','Garut','Malang','Sumedang','Kebun Organik'];
        $updated = 0;

        Produk::chunk(100, function($chunk) use (&$updated, $fakerOrigins){
            foreach ($chunk as $p) {
                $dirty = false;
                if (is_null($p->description)) {
                    $p->description = 'Produk '.$p->nama.' diproses dengan standar kualitas tinggi.\nSegar, higienis, dan siap digunakan untuk kebutuhan harian Anda.';
                    $dirty = true;
                }
                if (is_null($p->origin)) {
                    $p->origin = $fakerOrigins[array_rand($fakerOrigins)];
                    $dirty = true;
                }
                if (is_null($p->spec_html)) {
                    $p->spec_html = '<ul>'
                        .'<li><strong>Asal:</strong> '.($p->origin ?: 'Lokal').'</li>'
                        .'<li><strong>Kondisi:</strong> Segar</li>'
                        .'<li><strong>Kualitas:</strong> Grade A</li>'
                        .'<li><strong>Stok:</strong> '.($p->stok !== null ? $p->stok : 'Tersedia').'</li>'
                        .'</ul>';
                    $dirty = true;
                }
                if ($dirty) { $p->save(); $updated++; }
            }
        });

        $this->command->info("Produk enrichment selesai. Diperbarui: $updated record.");
    }
}
