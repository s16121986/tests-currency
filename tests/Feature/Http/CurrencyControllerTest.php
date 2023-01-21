<?php

namespace Http;

use Tests\TestCase;

class CurrencyControllerTest extends TestCase
{
	public function test_rates()
	{
		$response = $this->get('/currency/rates');

		$this->assertResponseSuccessStatus($response);
		$this->assertResponseResultStructure($response, [
			'*' => [
				'name',
				'char_code',
				'num_code',
				'nominal',
				'value'
			]
		]);
	}

	public function test_usd_rate()
	{
		$response = $this->get('/currency/usd');

		$this->assertResponseSuccessStatus($response);
		$this->assertResponseResultStructure($response, [
			'name',
			'char_code',
			'num_code',
			'nominal',
			'value'
		]);
	}
}
