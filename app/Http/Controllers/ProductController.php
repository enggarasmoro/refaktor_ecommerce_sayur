<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\ProductIndexRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
	public function __construct(private ProductService $service) {}

	/**
	 * List products for mobile infinite scroll.
	 */
	public function index(ProductIndexRequest $request): JsonResponse
	{
		$perPage = (int) $request->input('per_page', 6);
		$page = (int) $request->input('page', 1);
		$result = $this->service->listForMobile($perPage, $page);
		return response()->json($result);
	}

	/**
	 * Product detail endpoint.
	 */
	public function show(int $id): JsonResponse
	{
		$detail = $this->service->detail($id);
		return response()->json($detail);
	}

	/**
	 * Related products endpoint.
	 */
	public function related(int $id): JsonResponse
	{
		$related = $this->service->related($id, 9);
		return response()->json($related);
	}
}

