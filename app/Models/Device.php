<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany};

class Device extends Model
{
	protected $fillable = [
		'uuid',
		'board_id',
		'internal_id',
		'name',
		'is_passive',
		'is_reportable',
		'type',
	];

	protected $casts = [
		'is_passive'	=> 'boolean',
		'is_reportable'	=> 'boolean',
	];

	protected $hidden = [
		'board_id',
		'internal_id',
		'is_passive',
		'is_reportable'
	];

	/** @return BelongsTo */
	public function board()
	{
		return $this->belongsTo(Board::class);
	}

	/** @return BelongsToMany */
	public function abilities()
	{
		return $this->belongsToMany(Ability::class, table: 'device_abilities');
	}

	/** @return HasMany */
	public function states()
	{
		return $this->hasMany(DeviceState::class);
	}

	/**
	 * Get State array
	 *
	 * @param bool $convert
	 * @return array
	 */
	public function get_states($convert = true)
	{
		$states = $this->states->pluck('value', 'field');

		if ($convert) {
			$states = $states->mapWithKeys(function ($field, $value) {
				return [$field => Ability::convert_type($field, $value)];
			});
		}

		return $states;
	}
}
