<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasMany};

class Board extends Model
{
	protected $fillable = [
		'uuid',
		'fingerprint',
		'mac_address',
		'name',
		'board',
		'hw_version',
		'sw_version',
		'is_trusted'
	];

	/** @return HasMany */
	public function devices()
	{
		return $this->hasMany(Device::class);
	}

	/**
	 * Get only trusted boards
	 *
	 * @param mixed $query
	 * @return mixed
	 */
	public function scopeTrusted(mixed $query)
	{
		return $query->where('is_trusted', true);
	}
}
