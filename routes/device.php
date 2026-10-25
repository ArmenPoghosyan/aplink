<?php

use App\Http\Controllers\DeviceAPIController;
use Illuminate\Support\Facades\Route;

Route::get('iam',	[DeviceAPIController::class, 'iam']);
Route::get('alive',	[DeviceAPIController::class, 'live']);
