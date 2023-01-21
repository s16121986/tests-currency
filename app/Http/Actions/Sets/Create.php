<?php

namespace App\Http\Actions\Sets;

use App\Http\Response\ApiResponse;
use App\Models\Sets\Set;

class Create
{
	public function __construct() { }

	public function handle(array $currencyIds, ?string $description = null)
	{
		$set = Set::create([
			'description' => $description
		]);

		$set->setCurrenciesIds($currencyIds);

		return (new ApiResponse())
			->setResult([
				'id' => $set->id,
				'currencies' => $currencyIds
			], 201);
	}
}
