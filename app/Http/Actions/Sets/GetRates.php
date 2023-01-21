<?php

namespace App\Http\Actions\Sets;

use App\Http\Actions\Currency\GetRateByDate;
use App\Models\Sets\Set;
use App\Services\CurrencyRate\GetRateServiceInterface;

class GetRates
{
	public function __construct(private GetRateServiceInterface $service) { }

	public function handle($id, ?string $date)
	{
		$set = Set::find($id);
		if (!$set)
			return abort(404, ' Set not found');

		$date = GetRateByDate::dateFactory($date);

		$currencyIds = $set->currencies->pluck('currency')->toArray();

		$result = [];

		foreach ($this->service->getRatesByDate($date) as $rate) {
			if (in_array($rate->char_code, $currencyIds))
				$result[] = $rate;
		}

		return $result;
	}
}
