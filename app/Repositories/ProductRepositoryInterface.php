<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function paginateForMobile(int $perPage, int $page): LengthAwarePaginator;
    public function findActiveWithMedia(int $id);
}
