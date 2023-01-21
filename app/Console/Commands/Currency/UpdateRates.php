<?php


namespace App\Console\Commands\Currency;

use App\Services\CurrencyRate\GetRateServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class UpdateRates extends Command
{

	protected $signature = 'currency:update-rates
    {--date=}';

	protected $description = 'Кеширование курса валют на текущую(указанную) дату';

	public function __construct(private GetRateServiceInterface $service)
	{
		parent::__construct();
	}

	public function handle()
	{
		$dateOption = $this->option('date');
		$date = $dateOption ? Carbon::parse($dateOption) : now();

		Cache::forget('rates-' . $date->format('Y-m-d'));

		$this->service->getRatesByDate($date);
	}

}
