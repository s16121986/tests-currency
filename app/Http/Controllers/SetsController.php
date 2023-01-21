<?php

namespace App\Http\Controllers;

use App\Services\CurrencyRate\GetRateServiceInterface;
use App\Http\Actions\Sets as Actions;
use Illuminate\Http\Request;

class SetsController extends Controller
{
	public function __construct(private GetRateServiceInterface $ratesService) { }

	public function get($id, $date = null)
	{
		return (new Actions\GetRates($this->ratesService))->handle($id, $date);
	}

	public function create(Request $request)
	{
		return (new Actions\Create())->handle($request->post('ids'), $request->post('description'));
	}

	public function update(Request $request, $id)
	{
		return (new Actions\Update())->handle($id, $request->post('ids'), $request->post('description'));
	}
}
