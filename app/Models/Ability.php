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

	/**
	 * Get Ability ID by the field name
	 *
	 * @param string $field
	 * @return int|string|false
	 */
	public static function get_ability_id(string $field)
	{
		$fields = array_map(fn($ability) => $ability['field'], config('abilities', []));
		return array_search($field, $fields, true);
	}

	/**
	 * Get Ability field by the ID
	 *
	 * @param int $id
	 * @return string
	 */
	public static function get_ability_field(int $id)
	{
		return config("abilities.{$id}.field");
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
		$ability_id	= is_string($field) ? self::get_ability_id($field) : $field;
		$config		= config("abilities.{$ability_id}", null);

		if (!$config) return $value;

		return match ($config['type']) {
			'bool', 'boolean'	=> (bool)$value,
			'int', 'integer'	=> (int)$value,
			'string'			=> (string)$value,
			default				=> $value
		};
	}
}
