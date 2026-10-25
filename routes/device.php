<?php

use App\Http\Controllers\DeviceAPIController;
use Illuminate\Support\Facades\Route;

Route::post('iam',		[DeviceAPIController::class, 'iam']);
Route::post('alive',	[DeviceAPIController::class, 'live']);
