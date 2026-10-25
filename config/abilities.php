<?php

use App\Models\Ability;

return [
	Ability::ON_OFF		=> [
		'type'		=> 'boolean',
		'field'		=> 'on_off',
		'google'	=> [
			'trait'	=> 'action.devices.traits.OnOff'
		]
	],

	Ability::BRIGHTNESS	=> [
		'type'		=> 'integer',
		'field'		=> 'brightness',
		'google'	=> [
			'trait'	=> 'action.devices.traits.Brightness'
		]
	],

	Ability::COLOR		=> [
		'type'		=> 'integer',
		'field'		=> 'color',
		'google'	=> [
			'trait'	=> 'action.devices.traits.ColorSetting'
		]
	]
];
