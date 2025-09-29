<?php

namespace App\Http\Controllers;

use App\Services\BannerService;
use Illuminate\Http\JsonResponse;

class BannerController extends Controller
{
    public function __construct(private BannerService $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->mobileList());
    }
}
