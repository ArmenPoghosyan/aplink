<?php

namespace App\Http\Controllers;

use App\Models\{Ability, Board, Device};
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Str;

class DeviceAPIController extends Controller
{
	/**
	 * Device is representing itself
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function iam(Request $request)
	{
		$validated = $request->validate([
			'board'					=> 'required|array',
			'board.name'			=> 'required|string|max:255',
			'board.board'			=> 'required|string|max:255',
			'board.hw_version'		=> 'required|string|max:255',
			'board.sw_version'		=> 'required|string|max:255',
			'board.mac_address'		=> 'required|string|max:17',

			'devices'				=> 'required|array',
			'devices.*'				=> 'required|array',
			'devices.*.name'		=> 'required|string|max:255',
			'devices.*.type'		=> 'required|integer|gt:0',
			'devices.*.passive'		=> 'required|boolean',
			'devices.*.reportable'	=> 'required|boolean',

			'devices.*.abilities'	=> 'required|array',
			'devices.*.abilities.*'	=> 'required|integer|exists:abilities,id',

			'devices.*.state'		=> 'required|array',
		]);

		$board_details = $validated['board'];

		/** @var Board */
		$board = Board::firstOrCreate(
			['fingerprint' => $request->fingerprint,],
			[
				'uuid'			=> Str::orderedUuid(),
				'mac_address'	=> $board_details['mac_address'],
				'name'			=> $board_details['name'],
				'board'			=> $board_details['board'],
				'hw_version'	=> $board_details['hw_version'],
				'sw_version'	=> $board_details['sw_version'],
				'is_trusted'	=> false
			]
		);

		if ($board->is_trusted) {
			$devices = $validated['devices'];

			$current_state	= [];

			//* Sync each device
			foreach ($devices as $device_id => $device_details) {
				/** @var Device */
				$device = $board->devices()->firstOrCreate(
					['internal_id'	=> $device_id],
					[
						'uuid'			=> Str::orderedUuid(),
						'name'			=> $device_details['name'],
						'is_passive'	=> $device_details['passive'],
						'is_reportable'	=> $device_details['reportable'],
						'type'			=> $device_details['type'],
					]
				);

				// * Sync the abilities
				$device->abilities()->sync($device_details['abilities']);

				// * If the device is not passive - update the states
				if (!$device->is_passive) {
					// * Sync the states
					foreach ($device_details['state'] as $field => $value) {
						$device->states()->updateOrCreate(
							['field'	=> $field],
							['value'	=> $value],
						);
					}
				} else {
					$current_state[$device->internal_id] = $device->get_states();
				}
			}

			return success([
				'state'	=> $current_state
			]);
		}

		return fail([
			'message'	=> 'The board is not trusted'
		]);
	}

	/**
	 * Device is alive
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function alive(Request $request)
	{
		$fingerprint = $request->fingerprint();

		return response()->json(compact('fingerprint'));
	}
}
