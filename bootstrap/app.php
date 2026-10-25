<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
	->withRouting(
		web: __DIR__ . '/../routes/web.php',
		api: __DIR__ . '/../routes/api.php',
		commands: __DIR__ . '/../routes/console.php',
		health: '/up',
		then: function () {
			Route::domain(config('app.devices_domain'))
				->middleware('device')
				->group(base_path('routes/device.php'));
		},
	)
	->withMiddleware(function (Middleware $middleware): void {
		$middleware->web(append: [
			\App\Http\Middleware\HandleInertiaRequests::class,
			\Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
		]);

		$middleware->alias([
			'device' => \App\Http\Middleware\AuthenticateDevice::class,
		]);
	})
	->withExceptions(function (Exceptions $exceptions): void {
		$exceptions->shouldRenderJsonWhen(
			fn(Request $request) => $request->is('api/*') || $request->getHost() === config('app.devices_domain') || $request->expectsJson(),
		);
	})->create();
