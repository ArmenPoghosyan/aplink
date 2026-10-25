<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo};

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
}
