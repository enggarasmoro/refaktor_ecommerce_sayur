<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use App\Produk;
use App\ProductMedia;

class EnrichProdukCommand extends Command
{
    protected $signature = 'produk:enrich {--migrate-media : Copy image/video_url columns into product_media if columns still exist} {--ensure-media : Create placeholder media if product has no media rows}';
    protected $description = 'Isi description, origin, spec_html yang kosong dan (opsional) migrasi image/video ke product_media';

    public function handle(): int
    {
    $doMedia = $this->option('migrate-media');
    $ensureMedia = $this->option('ensure-media');
        $origins = ['Lokal','Bogor','Bandung','Garut','Malang','Sumedang','Kebun Organik','Impor'];
        $updated = 0; $mediaCreated = 0; $mediaSkipped = 0;

    Produk::with('medias')->chunk(100, function($chunk) use (&$updated,&$mediaCreated,&$mediaSkipped,$origins,$doMedia,$ensureMedia){
            foreach ($chunk as $p) {
                $dirty = false;
                // Enrich description
                if (empty($p->description)) {
                    $baseName = trim(preg_replace('/Produk\s+/i','',$p->nama));
                    $p->description = "${baseName} diproses dengan standar kualitas tinggi.\nSegar, higienis, dan siap memenuhi kebutuhan harian Anda.";
                    $dirty = true;
                }
                // Guess origin based on keywords in name
                if (empty($p->origin)) {
                    $lower = mb_strtolower($p->nama);
                    $detected = null;
                    foreach ($origins as $o) {
                        if (str_contains($lower, mb_strtolower($o))) { $detected = $o; break; }
                    }
                    $p->origin = $detected ?: $origins[array_rand($origins)];
                    $dirty = true;
                }
                if (empty($p->spec_html)) {
                    $p->spec_html = '<ul>'
                        .'<li><strong>Asal:</strong> '.e($p->origin).'</li>'
                        .'<li><strong>Kondisi:</strong> Segar</li>'
                        .'<li><strong>Kualitas:</strong> Grade A</li>'
                        .'<li><strong>Stok:</strong> '.($p->stok ?? 'Tersedia').'</li>'
                        .'</ul>';
                    $dirty = true;
                }
                if ($dirty) { $p->save(); $updated++; }

                if ($doMedia) {
                    // If columns still exist, migrate them
                    $imageVal = null; $videoVal = null;
                    if (Schema::hasColumn('produk','image')) { $imageVal = $p->getOriginal('image'); }
                    if (Schema::hasColumn('produk','video_url')) { $videoVal = $p->getOriginal('video_url'); }
                    // Add image as media if exists and not already present
                    if ($imageVal && !$p->medias->where('type','image')->where('url',$imageVal)->count()) {
                        ProductMedia::create([
                            'produk_id' => $p->id,
                            'type' => 'image',
                            'url' => $imageVal,
                            'position' => 0,
                        ]);
                        $mediaCreated++;
                    } elseif ($imageVal) { $mediaSkipped++; }
                    if ($videoVal && !$p->medias->where('type','video')->where('url',$videoVal)->count()) {
                        ProductMedia::create([
                            'produk_id' => $p->id,
                            'type' => 'video',
                            'url' => $videoVal,
                            'position' => 1,
                        ]);
                        $mediaCreated++;
                    } elseif ($videoVal) { $mediaSkipped++; }
                }
                if ($ensureMedia && $p->medias->count() === 0) {
                    ProductMedia::create([
                        'produk_id' => $p->id,
                        'type' => 'image',
                        'url' => 'https://picsum.photos/seed/placeholder'.$p->id.'/600/600',
                        'position' => 0,
                    ]);
                    $mediaCreated++;
                }
            }
        });

        $this->info("Enrichment selesai. Produk diperbarui: $updated");
    if ($doMedia || $ensureMedia) {
            $this->info("Media ditambahkan: $mediaCreated | Media dilewati (sudah ada): $mediaSkipped");
        }
        return 0;
    }
}
