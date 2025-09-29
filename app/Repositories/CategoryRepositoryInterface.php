<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function allActiveForMobile(): Collection;
}
