<?php

namespace App\Http\Actions\Currency;

use App\Services\CurrencyRate\GetRateServiceInterface;

class GetRatesByDate
{
	public function __construct(private GetRateServiceInterface $service) { }

	public function handle(?string $date)
	{
		$date = GetRateByDate::dateFactory($date);

		return $this->service->getRatesByDate($date);
	}
}
