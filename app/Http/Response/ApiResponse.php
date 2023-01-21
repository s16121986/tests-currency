<?php

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;

class ApiResponse extends JsonResponse
{

	public static function fromException(\Throwable $exception): static
	{
		return ErrorResponseFactory::build($exception);
	}

	public function __construct($data = null, $status = 200, $headers = [])
	{
		parent::__construct($data, $status, $headers);
	}

	public function setResult(mixed $data = [], int $statusCode = 200): static
	{
		return $this
			->setStatusCode($statusCode)
			->setData([
				'date' => date('Ymd\THis'),
				'status' => [
					'code' => 'ok',
					'message' => ''
				],
				'result' => $data
			]);
	}

}
