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
}
