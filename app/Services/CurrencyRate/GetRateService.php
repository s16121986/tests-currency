<?php

namespace App\Services\CurrencyRate;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class GetRateService implements GetRateServiceInterface
{

	public function __construct(private Api\ApiInterface $api) { }

	public function getCurrentRate(string $currency): \stdClass|null
	{
		return $this->getRateByDate($currency, now());
	}

	public function getRateByDate(string $currency, Carbon $date): \stdClass|null
	{
		$currency = strtoupper($currency);
		foreach ($this->getRatesByDate($date) as $rate) {
			if ($rate->char_code === $currency)
				return $rate;
		}
		return null;
	}

	public function getRatesByDate(Carbon $date): array
	{
		$cacheId = 'rates-' . $date->format('Y-m-d');
		if (Cache::has($cacheId))
			return Cache::get($cacheId);

		$rates = $this->api->getRatesByDate($date);

		Cache::put($cacheId, $rates, 3600);

		return $rates;
	}
}
