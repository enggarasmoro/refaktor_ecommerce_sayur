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
}
