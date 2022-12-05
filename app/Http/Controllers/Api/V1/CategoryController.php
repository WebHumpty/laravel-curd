<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\AppController;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\Responses\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CategoryController extends AppController
{
	/**
	 * CategoryController constructor.
	 *
	 * @param CategoryService $service
	 */
	public function __construct(CategoryService $service)
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
	 * @param CreateCategoryRequest $request
	 * @return JsonResponse
	 */
	public function store(CreateCategoryRequest $request): JsonResponse
	{
		$item = $this->service->save($request, null);

		return ResponseService::success($item);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return JsonResponse
	 */
	public function show(int $id): JsonResponse
	{
		$item = $this->service->find($id);

		if (is_null($item->resource)) {
			return ResponseService::notFound();
		}

		return ResponseService::success($item);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param UpdateCategoryRequest $request
	 * @param Category $category
	 * @return JsonResponse
	 */
	public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
	{
		$item = $this->service->save($request, $category);

		return ResponseService::success($item);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Category $category
	 * @return JsonResponse
	 */
	public function destroy(Category $category): JsonResponse
	{
		$status = $this->service->destroy($category);

		return ResponseService::sendJsonResponse($status, Response::HTTP_NO_CONTENT);
	}
}
