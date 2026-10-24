<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
	return $request->user();
})->middleware('auth:api');

Route::middleware('device')->prefix('device')->group(function () {
	Route::get('/ping', function (Request $request) {
		return response()->json(['device' => $request->all()]);
	});
});
