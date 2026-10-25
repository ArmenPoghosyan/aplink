<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasMany, HasOne};

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

	/** @return HasOne */
	public function channel()
	{
		return $this->hasOne(BoardChannel::class);
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

	/**
	 * Generate channel
	 *
	 * @param string $type
	 * @return BoardChannel
	 */
	public function generate_channel(string $type = BoardChannel::TYPE_MQTT): BoardChannel
	{
		$channel = $this->channel;
		$channel_string = BoardChannel::generate_channel_string();

		if ($channel) {
			$channel->update([
				'type'		=> $type,
				'channel'	=> $channel_string
			]);
		} else {
			$channel = $this->channel()->create([
				'type'		=> $type,
				'channel'	=> $channel_string
			]);
		}

		return $channel;
	}
}
