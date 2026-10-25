<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceState extends Model
{
	public $timestamps	= false;
	protected $fillable	= [
		'device_id',
		'field',
		'value'
	];

	/** @var BelongsTo */
	public function device()
	{
		return $this->belongsTo(Device::class);
	}
}
