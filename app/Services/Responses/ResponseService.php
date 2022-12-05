<?php

namespace App\Services\Responses;

use Illuminate\Http\JsonResponse;

class ResponseService
{
	/**
	 * веруть статус выполнено
	 *
	 * @param int $code
	 * @param object|null $data
	 * @return JsonResponse
	 */
	public static function success(object|null $data, int $code = 200): JsonResponse
	{
		return self::sendJsonResponse(true, $code, [], $data);
	}

	/**
	 * вернуть статус ресурс не найден
	 *
	 * @return JsonResponse
	 */
	public static function notFound(): JsonResponse
	{
		return self::sendJsonResponse(false, 404, [], null);
	}

	/**
	 * вернуть ответ серверу
	 *
	 * @param bool $status
	 * @param int $code
	 * @param array $errors
	 * @param object|null $data
	 * @return JsonResponse
	 */
	public static function sendJsonResponse(bool $status, int $code = 200, array $errors = [], object|null $data = null): JsonResponse
	{
		return response()->json(
			self::responseParams($status, $errors, $data)
		)->setStatusCode($code);
	}

	/**
	 * вернуть параметры ответа
	 *
	 * @param bool $status
	 * @param array $errors
	 * @param object|null $data
	 * @return array
	 */
	private static function responseParams(bool $status, array $errors = [], object|null $data = null): array
	{
		return [
			'status' => $status,
			'errors' => $errors,
			'data' => $data,
		];
	}
}
