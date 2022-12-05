<?php

namespace App\Http\Controllers;

use App\Services\BaseService;

class AppController extends Controller
{
	/** @var BaseService  */
	protected BaseService $service;

	/**
	 * AppController constructor.
	 *
	 * @param BaseService $service
	 */
	public function __construct(BaseService $service)
	{
		$this->service = $service;
	}
}
