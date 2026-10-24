<?php

namespace App\Http\Middleware;

use App\Models\Device;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Identifies a device by its TLS client certificate.
 *
 * The web server must request the certificate during the handshake
 * (SSLVerifyClient optional_no_ca / ssl_verify_client optional_no_ca) and pass it
 * to PHP as the SSL_CLIENT_CERT server variable. The certificate is self-signed,
 * so trust comes from its fingerprint being registered in the devices table.
 */
class AuthenticateDevice
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  Closure(Request): (Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$pem = rawurldecode((string) $request->server('SSL_CLIENT_CERT', ''));

		$fingerprint = $pem === '' ? false : openssl_x509_fingerprint($pem, 'sha256');

		dd($fingerprint);
		// $device = $fingerprint ? Device::where('fingerprint', $fingerprint)->first() : null;

		// if (! $device) {
		//     abort(401, 'Unknown or missing device certificate.');
		// }

		// $request->attributes->set('device', $device);

		return $next($request);
	}
}
