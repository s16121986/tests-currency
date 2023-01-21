<?php

namespace App\Models\Sets;

use App\Exceptions\ValidationFailedException;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{

	protected $table = 'custom_sets';

	protected $fillable = [
		'description',
	];

	protected $casts = [
	];

	public function currencies()
	{
		return $this->hasMany(Currencies::class);
	}

	public function setCurrenciesIds(array $ids)
	{
		$this->validateIds($ids);

		Currencies::where('set_id', $this->id)->delete();

		Currencies::insert(
			array_map(function ($id) {
				return [
					'set_id' => $this->id,
					'currency' => $id
				];
			}, $ids)
		);
	}

	private function validateIds(array $ids): void
	{
		if (empty($ids))
			throw new ValidationFailedException('Ids array empty');

		$a = array_unique($ids);
		if (count($a) !== count($ids))
			throw new ValidationFailedException('Ids array must be unique');

		foreach ($a as $id) {
			if (!preg_match('/^[A-Z]{3}$/', $id))
				throw new ValidationFailedException('Currency id validation failed, int required');
		}
	}
}
