<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'nama', 'id_kategori', 'info','harga','harga_diskon','discount_percent','stok','status','slug',
        'description','origin','brochure_image','spec_html'
    ];

    protected $appends = ['final_price','media_type','media'];

    protected $casts = [
        'harga' => 'integer',
        'harga_diskon' => 'integer',
        'stok' => 'integer',
        'discount_percent' => 'integer'
    ];

    public function toDetailArray(): array
    {
        // Use medias() relation (renamed to avoid collision with accessor)
        $mediaList = $this->medias()->orderBy('position')->get()->map(function($m){
            return [ 'type' => $m->type, 'url' => $m->url ];
        })->values();

        $specsArray = [
            ['label' => 'Berat', 'value' => $this->stok !== null ? $this->stok.' pcs' : '-'],
            ['label' => 'Asal', 'value' => $this->origin ?: 'Lokal'],
        ];

        // Brochure path normalization
        $brochure = null;
        if ($this->brochure_image) {
            $raw = $this->brochure_image;
            if (strpos($raw,'http')===0) {
                $brochure = $raw;
            } else {
                $candidates = [
                    'frontend/'.$raw,
                    $raw,
                    'images/'.$raw,
                    'images/brochure/'.$raw,
                    'storage/'.$raw,
                ];
                foreach ($candidates as $rel) {
                    $full = public_path($rel);
                    if (is_file($full)) { $brochure = asset($rel); break; }
                }
                if (!$brochure) {
                    // fallback guess
                    $brochure = asset('frontend/'.$raw);
                }
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->nama,
            'subtitle' => $this->info,
            'price' => (int) $this->final_price,
            'old_price' => (int) $this->harga,
            'discount' => $this->discount_percent ?? ($this->harga > $this->final_price ? (int) round(100 - ($this->final_price / $this->harga * 100)) : null),
            'media_type' => $this->media_type,
            'media' => $this->media,
            'description' => $this->description,
            'origin' => $this->origin,
            'stock' => $this->stok,
            'brochure_image' => $brochure,
            'media_list' => $mediaList,
            // If spec_html is provided (TinyMCE), frontend can render it directly, else use fallback specs array
            'spec_html' => $this->spec_html,
            'specs' => $this->spec_html ? [] : $specsArray,
        ];
    }

    // Renamed to avoid collision with appended 'media' accessor attribute
    public function medias()
    {
        return $this->hasMany(ProductMedia::class, 'produk_id');
    }

    public function getFinalPriceAttribute()
    {
        if ($this->discount_percent) {
            return (int) round($this->harga - ($this->harga * $this->discount_percent / 100));
        }
        if ($this->harga_diskon && $this->harga_diskon < $this->harga) {
            return (int) $this->harga_diskon;
        }
        return (int) $this->harga;
    }

    public function getMediaTypeAttribute()
    {
        $first = $this->medias()->orderBy('position')->first();
        return $first ? $first->type : 'image';
    }

    public function getMediaAttribute()
    {
        $first = $this->medias()->orderBy('position')->first();
        if ($first) return asset('frontend/'.$first->url);
        // placeholder fallback
        return asset('placeholder/product-placeholder.png');
    }
}
