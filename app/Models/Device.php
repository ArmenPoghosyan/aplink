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

	/** @return BelongsTo */
	public function board()
	{
		return $this->belongsTo(Board::class);
	}

	/** @return BelongsToMany */
	public function abilities()
	{
		return $this->belongsToMany(Ability::class);
	}

	/** @return HasMany */
	public function states()
	{
		return $this->hasMany(DeviceState::class);
	}
}
