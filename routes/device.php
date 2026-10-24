<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Served only on the device host (see bootstrap/app.php); the 'device' middleware identifies the caller.
Route::get('/ping', function (Request $request) {
	return response()->json(['device' => $request->all()]);
});
