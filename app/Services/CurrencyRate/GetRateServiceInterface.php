<?php

namespace App\Services\CurrencyRate;

use Illuminate\Support\Carbon;

interface GetRateServiceInterface
{

	public function getCurrentRate(string $currency): \stdClass|null;

	public function getRateByDate(string $currency, Carbon $date): \stdClass|null;

	public function getRatesByDate(Carbon $date): array;
}
