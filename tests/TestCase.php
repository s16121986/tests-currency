<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication;

	protected function assertResponseSuccessStatus($response, int $statusCode = 200)
	{
		$response
			->assertStatus($statusCode)
			->assertJson([
				'status' => [
					'code' => 'ok'
				]
			]);
	}

	protected function assertResponseResultStructure($response, array $structure)
	{
		$response->assertJsonStructure([
			'result' => $structure
		]);
	}
}
