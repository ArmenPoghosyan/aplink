<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo};

class BoardChannel extends Model
{
	const TYPE_MQTT		= 'mqtt';

	protected $fillable = [
		'device_id',
		'type',
		'channel',
	];

	/** @var BelongsTo */
	public function device()
	{
		return $this->belongsTo(Device::class);
	}

	/**
	 * Generate channel string
	 *
	 * @return string
	 */
	public static function generate_channel_string()
	{
		return \Illuminate\Support\Str::random(40);
	}
}
