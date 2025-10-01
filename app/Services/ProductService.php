<?php

namespace App\Services;

use App\Repositories\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function __construct(private ProductRepositoryInterface $products) {}

    public function listForMobile(int $perPage, int $page): array
    {
        $paginator = $this->products->paginateForMobile($perPage, $page);
        $items = $paginator->items();
        $data = array_map(function($p){
            return [
                'id' => $p->id,
                'name' => $p->nama,
                'subtitle' => $p->info,
                'size' => null,
                'price' => (int) $p->final_price,
                'old_price' => (int) $p->harga,
                'discount' => $p->discount_percent ?? ($p->harga > $p->final_price ? (int) round(100 - ($p->final_price / $p->harga * 100)) : null),
                'media_type' => $p->media_type,
                'media' => $p->media,
            ];
        }, $items);

        return [
            'data' => $data,
            'next_page' => $paginator->currentPage() < $paginator->lastPage() ? $paginator->currentPage() + 1 : false
        ];
    }

    public function detail(int $id): array
    {
        $produk = $this->products->findActiveWithMedia($id);
        return $produk->toDetailArray();
    }

    public function related(int $id, int $limit = 9): array
    {
        return [ 'data' => $this->products->related($id, $limit) ];
    }
}
