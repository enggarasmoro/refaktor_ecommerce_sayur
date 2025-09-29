<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use App\Produk;

/**
 * Seeder ini membaca file database/seeders/sql/produk.sql (hasil export lama)
 * yang berisi baris INSERT INTO `produk` ... dan memasukkannya ke schema baru.
 * Kolom baru (description, origin, brochure_image, spec_html, video_url, discount_percent, stok)
 * akan diisi default jika tidak ada di dump.
 */
class ProdukSqlImportSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/sql/produk.sql');
        if (!file_exists($path)) {
            $this->command->warn("File produk.sql tidak ditemukan: $path");
            return;
        }

        $raw = file_get_contents($path);
        if (!$raw) {
            $this->command->warn('File produk.sql kosong.');
            return;
        }

        // Ambil hanya baris INSERT INTO produk
        $lines = preg_split('/;\s*\n/', $raw); // pisah per statement
        $insertLines = array_filter($lines, function($l){ return stripos($l, 'insert into') !== false && stripos($l,'produk') !== false; });
        if (!count($insertLines)) {
            $this->command->warn('Tidak ada baris INSERT produk ditemukan.');
            return;
        }

        $imported = 0; $skipped = 0; $updated = 0;

        foreach ($insertLines as $stmt) {
            // Contoh pola: INSERT INTO `produk` (`id`,`nama`,`image`, ... ) VALUES (...),(...)
            if (!preg_match('/INSERT\s+INTO\s+`?produk`?\s*\(([^)]+)\)\s*VALUES\s*(.+)/i', $stmt, $m)) {
                $skipped++; continue;
            }
            $columnsRaw = $m[1];
            $valuesRaw = rtrim($m[2]);

            // Kolom
            $cols = array_map(function($c){ return trim(str_replace(['`','"'],'',$c)); }, explode(',', $columnsRaw));

            // Pecah values menjadi grup per (...)
            $valueGroups = [];
            $depth = 0; $current = '';
            for ($i=0; $i<strlen($valuesRaw); $i++) {
                $ch = $valuesRaw[$i];
                if ($ch === '(') { if ($depth===0) $current=''; $depth++; $current .= $ch; continue; }
                if ($ch === ')') { $depth--; $current .= $ch; if ($depth===0) { $valueGroups[] = $current; $current=''; } continue; }
                if ($depth>0) { $current .= $ch; }
            }

            foreach ($valueGroups as $group) {
                $inside = trim($group, '()');
                // Split by comma respecting quotes
                $parts = $this->splitCsvPreserveQuotes($inside);
                if (count($parts) !== count($cols)) { $skipped++; continue; }
                $row = [];
                foreach ($cols as $idx=>$cName) {
                    $val = $this->cleanValue($parts[$idx]);
                    $row[$cName] = $val;
                }

                // Mapping kolom lama -> baru
                $payload = [
                    'nama' => $row['nama'] ?? ($row['name'] ?? 'Produk Tanpa Nama'),
                    'image' => $row['image'] ?? ($row['gambar'] ?? ''),
                    'info' => $row['info'] ?? ($row['subtitle'] ?? ''),
                    'harga' => (int) ($row['harga'] ?? ($row['price'] ?? 0)),
                    'harga_diskon' => (int) ($row['harga_diskon'] ?? ($row['discount_price'] ?? ($row['harga'] ?? 0))),
                    'slug' => $row['slug'] ?? null,
                    'status' => isset($row['status']) ? (int) $row['status'] : 1,
                ];
                if (Schema::hasColumn('produk','id_kategori')) {
                    $payload['id_kategori'] = $row['id_kategori'] ?? ($row['kategori_id'] ?? 1);
                }
                if (Schema::hasColumn('produk','discount_percent')) {
                    $payload['discount_percent'] = isset($row['discount_percent']) ? (int) $row['discount_percent'] : null;
                }
                if (Schema::hasColumn('produk','stok')) {
                    $payload['stok'] = isset($row['stok']) ? (int) $row['stok'] : 0;
                }
                if (Schema::hasColumn('produk','video_url')) {
                    $payload['video_url'] = $row['video_url'] ?? null;
                }
                if (Schema::hasColumn('produk','description')) {
                    $payload['description'] = $row['description'] ?? null;
                }
                if (Schema::hasColumn('produk','origin')) {
                    $payload['origin'] = $row['origin'] ?? null;
                }
                if (Schema::hasColumn('produk','brochure_image')) {
                    $payload['brochure_image'] = $row['brochure_image'] ?? null;
                }
                if (Schema::hasColumn('produk','spec_html')) {
                    $payload['spec_html'] = $row['spec_html'] ?? null;
                }

                // Upsert by slug jika ada, else by nama+harga combination
                $existing = null;
                if (!empty($payload['slug'])) {
                    $existing = Produk::where('slug',$payload['slug'])->first();
                }
                if (!$existing) {
                    $existing = Produk::where('nama',$payload['nama'])->where('harga',$payload['harga'])->first();
                }

                if ($existing) {
                    $existing->fill($payload);
                    $existing->save();
                    $updated++;
                } else {
                    Produk::create($payload);
                    $imported++;
                }
            }
        }

        $this->command->info("Produk SQL import selesai. Imported: $imported, Updated: $updated, Skipped: $skipped");
    }

    private function cleanValue(string $raw)
    {
        $val = trim($raw);
        if ($val === 'NULL' || $val === 'null') return null;
        // remove surrounding quotes
        if ((str_starts_with($val,"'") && str_ends_with($val,"'")) || (str_starts_with($val,'"') && str_ends_with($val,'"'))) {
            $val = substr($val,1,-1);
        }
        // unescape simple quotes
        $val = str_replace(["\\'","\\\""],['"','"'],$val);
        return $val;
    }

    private function splitCsvPreserveQuotes(string $s): array
    {
        $out = []; $buf=''; $inQuote = false; $quoteChar=''; $len=strlen($s);
        for ($i=0;$i<$len;$i++) {
            $ch = $s[$i];
            if (($ch==="'" || $ch==='"')) {
                if (!$inQuote) { $inQuote=true; $quoteChar=$ch; $buf.=$ch; continue; }
                if ($inQuote && $ch===$quoteChar) {
                    // lookahead for escaped quote
                    if ($i+1<$len && $s[$i+1]===$quoteChar) { $buf.=$ch; $i++; $buf.=$ch; continue; }
                    $inQuote=false; $quoteChar=''; $buf.=$ch; continue;
                }
            }
            if ($ch===',' && !$inQuote) { $out[] = trim($buf); $buf=''; continue; }
            $buf .= $ch;
        }
        if (strlen(trim($buf))) $out[] = trim($buf);
        return $out;
    }
}
