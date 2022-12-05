<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product as Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductService extends BaseService
{
	/**
	 * вернуть имя модели
	 *
	 * @return string
	 */
	protected function getClassModel(): string
	{
		return Model::class;
	}

	/**
	 * вернуть товар
	 *
	 * @param Model $model
	 * @return ProductResource
	 */
	public function getOne(Model $model): ProductResource
	{
		return new ProductResource($model);
	}

	/**
	 * верунть все товары
	 *
	 * @return AnonymousResourceCollection
	 */
	public function getAll(): AnonymousResourceCollection
	{
		$items = $this->startConditions()->get();

		return ProductResource::collection($items);
	}

	/**
	 * сохранить/обновить модель в хранилище
	 *
	 * @param FormRequest $request
	 * @param Model|null $model
	 * @return ProductResource
	 */
	public function save(FormRequest $request, Model|null $model): ProductResource
	{
		if (is_null($model)) {
			$item = $this->startConditions();
			$model = $item->create($request->only($item->getFillable()));
		} else {
			$model->update($request->only($model->getFillable()));
		}

		return new ProductResource($model);
	}

	/**
	 * удалить модель из хранилища
	 *
	 * @param Model $model
	 * @return bool
	 */
	public function destroy(Model $model): bool
	{
		return $model->delete();
	}
}
