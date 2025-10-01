<?php

namespace App\Repositories;

use App\Produk;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function paginateForMobile(int $perPage, int $page): LengthAwarePaginator
    {
        $query = Produk::with(['medias' => function($q){ $q->orderBy('position'); }])
            ->where('status',1)
            ->orderBy('id','desc');
        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function findActiveWithMedia(int $id)
    {
        return Produk::with(['medias' => function($q){ $q->orderBy('position'); }])
            ->where('status',1)
            ->findOrFail($id);
    }

    public function related(int $id, int $limit = 9): array
    {
        // First get category ids for this product (through prod_kategori pivot)
        $categoryIds = \DB::table('prod_kategori')
            ->where('id_produk', $id)
            ->pluck('id_kategori')
            ->filter()
            ->unique()
            ->values();

        $baseQuery = Produk::query()->where('status',1)->where('id','!=',$id);

        if ($categoryIds->count()) {
            $related = $baseQuery->whereExists(function($q) use ($categoryIds){
                $q->selectRaw(1)
                  ->from('prod_kategori as pk')
                  ->whereColumn('pk.id_produk','produk.id')
                  ->whereIn('pk.id_kategori', $categoryIds);
            })
            ->orderBy('id','desc')
            ->limit($limit)
            ->get();
        } else {
            $related = collect();
        }

        if ($related->count() === 0) {
            // fallback random active excluding current
            $related = $baseQuery->inRandomOrder()->limit($limit)->get();
        }

        return $related->map(function($p){
            return [
                'id' => $p->id,
                'name' => $p->nama,
                'subtitle' => $p->info,
                'price' => (int) $p->final_price,
                'old_price' => (int) $p->harga,
                'discount' => $p->discount_percent ?? ($p->harga > $p->final_price ? (int) round(100 - ($p->final_price / $p->harga * 100)) : null),
                'media_type' => $p->media_type,
                'media' => $p->media,
            ];
        })->values()->all();
    }
}
