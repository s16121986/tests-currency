<?php

namespace App\Services\CurrencyRate\Api;

use Illuminate\Support\Carbon;
use Exception;

class SberApi implements ApiInterface
{

	const DAILY = 'http://www.cbr.ru/scripts/XML_daily.asp';

	public function getRatesByDate(Carbon $date): array
	{
		$xml = $this->query(self::DAILY, ['date_req' => static::dateFormat($date)]);

		$path = $xml->xpath('Valute');

		$rates = [];
		foreach ($path as $r) {
			$rates[] = (object)[
				'name' => (string)$r->Name,
				'num_code' => (string)$r->NumCode,
				'char_code' => strtoupper((string)$r->CharCode),
				'nominal' => (int)(string)$r->Nominal,
				'value' => self::rateFormat((string)$r->Value)
			];
		}

		return $rates;
	}

	/**
	 * @throws Exception
	 */
	private function query($url, $params = []): \SimpleXMLElement
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url . ($params ? '?' . http_build_query($params) : ''));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		$out = curl_exec($ch);

		$this->validateCurl($ch);

		curl_close($ch);

		try {
			return simplexml_load_string($out);
		} catch (Exception $e) {
			throw new Exception('Cant parse xml data', null, $e);
		}
	}

	private function validateCurl($ch)
	{
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if (200 !== $httpCode) {
			$errorNo = curl_errno($ch);
			$error = curl_error($ch);
			curl_close($ch);

			throw new Exception($httpCode . ': ' . ($errorNo ? $error : 'SberApi unavailable'));
		}
	}

	private static function dateFormat($date): string
	{
		return $date->format('d/m/Y');
	}

	private static function rateFormat(string $rate): float
	{
		return (float)str_replace(',', '.', $rate);
	}

}
