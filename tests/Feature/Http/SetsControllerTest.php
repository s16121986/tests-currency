<?php

namespace Http;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SetsControllerTest extends TestCase
{
	//use DatabaseTransactions;

	public function test_create()
	{
		$response = $this->post('/sets', [
			'ids' => ['USD', 'EUR'],
			'description' => 'test_create'
		]);

		$this->assertResponseSuccessStatus($response, 201);
		$this->assertResponseResultStructure($response, [
			'id',
			'currencies',
		]);

		return $response->getOriginalContent()['result']['id'];
	}

	/**
	 * @depends test_create
	 */
	public function test_update($id)
	{
		$response = $this->post('/sets/' . $id, [
			'ids' => ['USD'],
			'description' => 'test_update'
		]);

		$this->assertResponseSuccessStatus($response);
		$this->assertResponseResultStructure($response, [
			'id',
			'currencies',
		]);

		return $id;
	}

	/**
	 * @depends test_update
	 */
	public function test_get_set_rates($id)
	{
		$response = $this->get('/sets/' . $id);

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
}
