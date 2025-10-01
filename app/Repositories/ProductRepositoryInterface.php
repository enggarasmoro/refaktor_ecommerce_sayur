<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function paginateForMobile(int $perPage, int $page): LengthAwarePaginator;
    public function findActiveWithMedia(int $id);
    /**
     * Get up to $limit related products based on shared categories (prod_kategori table).
     * If none found, return random active products excluding the current one.
     */
    public function related(int $id, int $limit = 9): array;
}
