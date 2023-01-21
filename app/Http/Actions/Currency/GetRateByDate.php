<?php

namespace App\Http\Actions\Currency;

use App\Exceptions\ValidationFailedException;
use App\Services\CurrencyRate\GetRateServiceInterface;
use Illuminate\Support\Carbon;

class GetRateByDate
{
	public function __construct(private GetRateServiceInterface $service) { }

	public function handle(string $currencyCode, ?string $date)
	{
		$date = self::dateFactory($date);

		$rate = $this->service->getRateByDate($currencyCode, $date);

		if (null === $rate)
			return abort(404, 'Currency [' . $currencyCode . '] not found');

		return $rate;
	}

	public static function dateFactory(?string $date)
	{
		if (null === $date)
			return now();

		else if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date))
			throw new ValidationFailedException('Date format invalid');

		else if ($date > now()->format('Y-m-d'))
			throw new ValidationFailedException('Only past date available');

		return Carbon::parse($date);
	}
}
