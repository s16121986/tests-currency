<?php

namespace App\Http\Actions\Sets;

use App\Models\Sets\Set;

class Update
{

	public function handle($id, ?array $currencyIds, ?string $description = null)
	{
		$set = Set::find($id);
		if (!$set)
			return abort(404, ' Set not found');

		if ($description)
			$set->update(['description' => $description]);

		if (null !== $currencyIds)
			$set->setCurrenciesIds($currencyIds);

		return [
			'id' => $set->id,
			'currencies' => $currencyIds
		];
	}
}
