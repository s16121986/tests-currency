<?php

namespace App\Http\Controllers;

use App\Services\CurrencyRate\GetRateServiceInterface;
use App\Http\Actions\Currency as Actions;

class CurrencyController extends Controller
{
    public function __construct(private GetRateServiceInterface $ratesService) { }

    public function rateByDate($currencyCode, $date = null)
    {
        return (new Actions\GetRateByDate($this->ratesService))->handle($currencyCode, $date);
    }

    public function ratesByDate($date = null)
    {
        return (new Actions\GetRatesByDate($this->ratesService))->handle($date);
    }
}
