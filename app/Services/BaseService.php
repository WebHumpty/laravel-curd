<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
	/** @var Model  */
	protected Model $model;

	/**
	 * BaseService constructor.
	 */
	public function __construct()
	{
		$this->model = app($this->getClassModel());
	}

	/**
	 * вернуть имя модели
	 *
	 * @return string
	 */
	abstract protected function getClassModel(): string;

	/**
	 * вернуть клон модели
	 *
	 * @return Model
	 */
	protected function startConditions(): Model
	{
		return clone $this->model;
	}
}
