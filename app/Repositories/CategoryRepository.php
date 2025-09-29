<?php

namespace App\Repositories;

use App\Kategori;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function allActiveForMobile(): Collection
    {
        return Kategori::where('status','1')->orderBy('nama','asc')->get();
    }
}
