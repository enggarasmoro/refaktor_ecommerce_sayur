<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function paginateForMobile(int $perPage, int $page): LengthAwarePaginator;
    public function findActiveWithMedia(int $id);
}

interface CategoryRepositoryInterface
{
    public function allActiveForMobile(): Collection;
}
