<?php

namespace App\Http\Controllers;

use App\Http\Response\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function callAction($method, $parameters)
	{
		$callMethod = $method;// . 'Action';
		if (!method_exists($this, $callMethod))
			throw new abort(404, 'Method "' . $method . '" undefined');

		$response = call_user_func_array([$this, $callMethod], array_values($parameters));
		if ($response instanceof JsonResponse)
			return $response;
		else
			return (new ApiResponse())->setResult($response);
	}
}
