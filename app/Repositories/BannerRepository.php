<?php

namespace App\Repositories;

use App\Banner;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class BannerRepository implements BannerRepositoryInterface
{
    public function allActiveForMobile(): Collection
    {
        $query = Banner::query()->where('status',1);
    if (Schema::hasColumn('banner','position')) {
            $query->orderBy('position');
        } else {
            $query->orderByDesc('id');
        }
        return $query->get();
    }
}
