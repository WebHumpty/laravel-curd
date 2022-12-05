<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\AppController;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use App\Services\Responses\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductController extends AppController
{
	/**
	 * ProductController constructor.
	 *
	 * @param ProductService $service
	 */
	public function __construct(ProductService $service)
	{
		parent::__construct($service);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return JsonResponse
	 */
	public function index(): JsonResponse
	{
		$items = $this->service->getAll();

		return ResponseService::success($items);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateProductRequest $request
	 * @return JsonResponse
	 */
	public function store(CreateProductRequest $request): JsonResponse
	{
		$item = $this->service->save($request, null);

		return ResponseService::success($item);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Product $product
	 * @return JsonResponse
	 */
	public function show(Product $product): JsonResponse
	{
		$item = $this->service->getOne($product);

		return ResponseService::success($item);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param UpdateProductRequest $request
	 * @param Product $product
	 * @return JsonResponse
	 */
	public function update(UpdateProductRequest $request, Product $product): JsonResponse
	{
		$item = $this->service->save($request, $product);

		return ResponseService::success($item);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Product $product
	 * @return JsonResponse
	 */
	public function destroy(Product $product): JsonResponse
	{
		$status = $this->service->destroy($product);

		return ResponseService::sendJsonResponse($status, Response::HTTP_NO_CONTENT);
	}
}
