<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface BannerRepositoryInterface
{
    public function allActiveForMobile(): Collection;
}
