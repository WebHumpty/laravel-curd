<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use App\Models\Category as Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryService extends BaseService
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
	 * вернуть категорию
	 *
	 * @param int $id
	 * @return CategoryResource
	 */
	public function find(int $id): CategoryResource
	{
		$item = $this->startConditions()->find($id);

		return new CategoryResource($item);
	}

	/**
	 * вернуть все категории
	 *
	 * @return AnonymousResourceCollection
	 */
	public function getAll(): AnonymousResourceCollection
	{
		$items = $this->startConditions()->get();

		return CategoryResource::collection($items);
	}

	/**
	 * сохранить/обновить модель в хранилище
	 *
	 * @param FormRequest $request
	 * @param Model|null $model
	 * @return CategoryResource
	 */
	public function save(FormRequest $request, Model|null $model): CategoryResource
	{
		if (is_null($model)) {
			$item = $this->startConditions();
			$model = $this->startConditions()->create($request->only($item->getFillable()));
		} else {
			$model->update($request->only($model->getFillable()));
		}

		return new CategoryResource($model);
	}

	/**
	 * удалить категорию из хранилища
	 *
	 * @param Model $model
	 * @return bool
	 */
	public function destroy(Model $model): bool
	{
		return $model->delete();
	}
}
