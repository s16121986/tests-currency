<?php

namespace App\Services\CurrencyRate\Api;

use Illuminate\Support\Carbon;

interface ApiInterface
{
	public function getRatesByDate(Carbon $date): array;
}
