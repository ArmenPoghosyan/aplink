<?php

namespace App\Http\Controllers;

use App\Models\{Board};
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
			'board'				=> 'required|array',
			'board.name'		=> 'required|string|max:255',
			'board.board'		=> 'required|string|max:255',
			'board.hw_version'	=> 'required|string|max:255',
			'board.sw_version'	=> 'required|string|max:255',
			'board.mac_address'	=> 'required|string|max:17',
		]);

		$board_details = $validated['board'];

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
			return success([
				'message'	=> 'The board is trusted'
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
