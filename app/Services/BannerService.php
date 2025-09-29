<?php

namespace App\Services;

use App\Repositories\BannerRepositoryInterface;
use App\Http\Resources\Api\BannerResource;

class BannerService
{
    public function __construct(private BannerRepositoryInterface $banners) {}

    public function mobileList(): array
    {
        $raw = $this->banners->allActiveForMobile();
        foreach ($raw as $banner) {
            $banner->image_url = null;
            if ($banner->image) {
                $banner->image_url = (strpos($banner->image,'http')===0)
                    ? $banner->image
                    : asset('frontend/'.$banner->image);
            }
        }
        $collection = BannerResource::collection($raw);
        return [
            'success' => true,
            'data' => $collection->toArray(request()),
            'meta' => ['count' => count($raw)]
        ];
    }
}
