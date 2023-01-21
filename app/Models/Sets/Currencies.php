<?php

namespace App\Models\Sets;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
	protected $primaryKey = null;

	public $incrementing = false;

	public $timestamps = false;

	protected $table = 'custom_set_currencies';

	protected $fillable = [
		'set_id',
		'currency',
	];

	protected $casts = [
		'set_id' => 'int',
	];
}
