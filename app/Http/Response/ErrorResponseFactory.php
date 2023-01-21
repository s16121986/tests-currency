<?php

namespace App\Http\Response;

use App\Exceptions\AppErrorException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class ErrorResponseFactory
{

	public static function build(\Throwable $e): ApiResponse
	{
		if ($e instanceof NotFoundHttpException)
			return self::buildNotFound($e);

		else if ($e instanceof HttpException)
			return self::buildHttpException($e);

		else if ($e instanceof AppErrorException)
			return self::buildErrorException($e);

		else
			return self::_response([
				'message' => $e->getMessage(),
				'error' => -1
			], 500);
	}

	private static function buildNotFound(NotFoundHttpException $e): ApiResponse
	{
		return static::_response([
			'message' => $e->getMessage() ?: 'Not Found',
			'error' => 0
		], 404, $e->getHeaders());
	}

	private static function buildErrorException(AppErrorException $e): ApiResponse
	{
		return self::_response([
			'message' => $e->getMessage(),
			'error' => $e->getCode()
		], AppErrorException::HTTP_STATUS_CODE);
	}

	private static function buildHttpException(HttpException $e): ApiResponse
	{
		return self::_response([
			'message' => $e->getMessage(),
			'error' => $e->getCode()
		], $e->getStatusCode(), $e->getHeaders());
	}

	private static function _response($status, $httpCode, array $headers = []): ApiResponse
	{
		return new ApiResponse([
			'date' => date('Ymd\THis'),
			'status' => array_merge(['code' => 'error'], $status)
		], $httpCode, $headers);
	}
}
