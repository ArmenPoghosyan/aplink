<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
		$fingerprint = $request->fingerprint;

		return response()->json(compact('fingerprint'));
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
