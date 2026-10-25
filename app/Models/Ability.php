<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
	public $timestamps	= false;
	protected $fillable	= ['field'];

	const ON_OFF		= 1;
	const BRIGHTNESS	= 2;
	const COLOR			= 3;

	const ABILITIES		= [
		self::ON_OFF		=> 'on_off',
		self::BRIGHTNESS	=> 'brightness',
		self::COLOR			=> 'color'
	];

	/**
	 * Get Ability ID by the field name
	 *
	 * @param string $field
	 * @return int|string|false
	 */
	public static function get_ability_id(string $field)
	{
		return array_search($field, self::ABILITIES, true);
	}

	/**
	 * Get Ability field by the ID
	 *
	 * @param int $id
	 * @return string
	 */
	public static function get_ability_field(int $id)
	{
		return self::ABILITIES[$id] ?? null;
	}

	/**
	 * Get the ability value in the correct type representation
	 *
	 * @param string|int $field
	 * @param mixed $value
	 * @return mixed
	 */
	public static function convert_type(string|int $field, mixed $value)
	{
		$field = is_string($field) ? self::get_ability_id($field) : $field;

		return match ($field) {
			self::ON_OFF		=> (bool)$value,
			self::BRIGHTNESS	=> (int)$value,
			self::COLOR			=> (int)$value,
			default				=> $value
		};
	}
}
