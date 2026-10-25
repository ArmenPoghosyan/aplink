<?php

use Illuminate\Http\JsonResponse;
use App\Models\{User};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

#region User

/**
 * Get the user
 *
 * @param bool $with_all
 * @return null|User
 */
function auth_user($with_all = false): ?User
{
	if ($user = \Illuminate\Support\Facades\Auth::user()) {
		if ($with_all) {
			$user = User::with_all()->find($user->id);
		}

		return $user;
	}

	return null;
}

/**
 * Get the user's id
 *
 * @return null|int
 */
function user_id(): ?int
{
	return auth_user()?->id ?? null;
}

/**
 * Throw an unauthorized exception
 *
 * @return never
 * @throws UnauthorizedException
 */
function unauthorized()
{
	throw new \Illuminate\Validation\UnauthorizedException();
}
#endregion

#region Status
/**
 * Return a response with a status
 *
 * @param mixed $status
 * @param array $data
 * @param int $code
 * @return JsonResponse
 */
function status($status, $data = [], $code = 200)
{
	return new JsonResponse(
		['status' => $status] + $data,
		$code
	);
}

/**
 * Return a successful response
 *
 * @param array $data
 * @param int $code
 * @return JsonResponse
 */
function success($data = [], $code = 200)
{
	return status(true, $data, $code);
}

/**
 * Return a failed response
 *
 * @param array $data
 * @param int $code
 * @return JsonResponse
 */
function fail($data = [], $code = 200)
{
	return status(false, $data, $code);
}

/**
 * Return an inertia response
 *
 * @param mixed $data
 * @return void
 */
function inertia_response($data)
{
	if ($data instanceof JsonResponse) {
		$data = $data->getData(true);
	}

	session()->flash('response', $data);
}
#endregion

/**
 * Get User IP
 * @return mixed
 */
function user_ip()
{
	// Get real visitor IP behind CloudFlare network
	if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
		$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		$_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}

	// Sometimes the `HTTP_CLIENT_IP` can be used by proxy servers
	$ip = @$_SERVER['HTTP_CLIENT_IP'];
	if (filter_var($ip, FILTER_VALIDATE_IP)) {
		return $ip;
	}

	// Sometimes the `HTTP_X_FORWARDED_FOR` can contain more than IPs
	$forward_ips = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	if ($forward_ips) {
		$all_ips = explode(',', $forward_ips);

		foreach ($all_ips as $ip) {
			if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
				return $ip;
			}
		}
	}

	return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
}

/**
 * Get User Agent
 *
 * @return string|null
 */
function user_agent()
{
	return request()->userAgent();
}

/**
 * Get the relative path from the base path
 *
 * @param mixed $path
 * @return string|string[]
 */
function relative_path($path)
{
	return ltrim(str_replace([base_path(), '/', '\\'], ['', DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $path), DIRECTORY_SEPARATOR);
}

/**
 * Get the morphed name of the model
 *
 * @param mixed $class
 * @return mixed
 */
function morphed_name($class)
{
	return array_search($class, \Illuminate\Database\Eloquent\Relations\Relation::morphMap()) ?: $class;
}

/**
 * Get the class name from the morphed name
 *
 * @param mixed $name
 * @return mixed
 */
function morph_to_class($name)
{
	$map = \Illuminate\Database\Eloquent\Relations\Relation::morphMap();
	return $map[$name] ?? $name;
}

/**
 * Find a model by its morphed name and id
 *
 * @param mixed $name
 * @param mixed $id
 * @return Model|null
 */
function find_morphed_model($name, $id): Model|null
{
	$class = morph_to_class($name);
	if (class_exists($class)) {
		return $class::find($id);
	}

	return null;
}

/**
 * Get the page limit from the request\
 *
 * @param int $limit
 * @return mixed
 */
function get_page_limit($limit = 20)
{
	return request()->get('limit', $limit);
}

/**
 * Convert seconds to human readable format
 *
 * @param mixed $seconds
 * @param string $locale
 * @return string
 */
function plural_seconds($seconds, $locale = 'en')
{
	$result		= [];

	$hours		= floor($seconds / 3600);
	$minutes	= floor(($seconds / 60) % 60);
	$seconds	= $seconds % 60;


	switch ($locale) {
		case 'ru':
			$hour_titles		= ['час', 'часа', 'часов'];
			$minute_titles		= ['минута', 'минуты', 'минут'];
			$second_titles		= ['секунда', 'секунды', 'секунд'];

			$cases = [2, 0, 1, 1, 1, 2];

			if ($hours > 0) {
				$result[] = $hours;
				$result[] = $hour_titles[($hours % 100 > 4 && $hours % 100 < 20) ? 2 : $cases[min($hours % 10, 5)]];
			}

			if ($minutes > 0) {
				$result[] = $minutes;
				$result[] = $minute_titles[($minutes % 100 > 4 && $minutes % 100 < 20) ? 2 : $cases[min($minutes % 10, 5)]];
			}

			if ($seconds > 0 && $hours == 0 && $minutes == 0) {
				$result[] = $seconds;
				$result[] = $second_titles[($seconds % 100 > 4 && $seconds % 100 < 20) ? 2 : $cases[min($seconds % 10, 5)]];
			}
			break;

		case 'en':
		default:
			if ($hours > 0) {
				$result[] = $hours;
				$result[] = $hours > 1 ? 'hours' : 'hour';
			}

			if ($minutes > 0) {
				$result[] = $minutes;
				$result[] = $minutes > 1 ? 'minutes' : 'minute';
			}

			if ($seconds > 0 && $hours == 0 && $minutes == 0) {
				$result[] = $seconds;
				$result[] = $seconds > 1 ? 'seconds' : 'second';
			}
			break;
	}

	return implode(' ', $result);
}

/**
 * Calculate discounted price
 *
 * @param mixed $price
 * @param mixed $discount
 * @return mixed
 */
function calculate_discounted_price($price, $discount)
{
	if ($discount > 0) {
		return (int)round($price - ($price * $discount / 100));
	}

	return $price;
}

/**
 * Convert an associative array to HTML attributes
 *
 * @param mixed $array
 * @return array<string|int, mixed>
 */
function array_to_attributes($array)
{
	$array = array_map(function ($value, $key) {
		if (is_bool($value)) {
			return $key;
		}
		return $key . '="' . e($value) . '"';
	}, $array, array_keys($array));

	return implode(' ', $array);
}

/**
 * Search for files in a folder
 *
 * @param mixed $folder
 * @param mixed $pattern
 * @return array
 */
function recursive_search($folder, $pattern)
{
	$dir = new RecursiveDirectoryIterator($folder);
	$ite = new RecursiveIteratorIterator($dir);
	$files = new RegexIterator($ite, $pattern, RegexIterator::GET_MATCH);
	$fileList = array();
	foreach ($files as $file) {
		$fileList[] = $file[0];
	}
	return $fileList;
}

/**
 * Normalize a path to use the correct directory separator
 *
 * @param mixed $path
 * @return string|string[]
 */
function normalize_path($path)
{
	return str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $path);
}

/**
 * Format file size
 * @param mixed $size
 * @return string
 */
function format_file_size($size)
{
	$units = ['B', 'KB', 'MB', 'GB', 'TB'];

	$index = 0;
	while ($size >= 1024 && $index < count($units) - 1) {
		$size /= 1024;
		$index++;
	}

	return round($size, 2) . ' ' . $units[$index];
}

/**
 * Convert duration string to minutes
 *
 * @param string $duration
 * @return int
 */
function get_duration_in_minutes(string $duration): int
{
	return match ($duration) {
		'5min'			=> 5,
		'15min'			=> 15,
		'30min'			=> 30,
		'1hour'			=> 60,
		'3hours'		=> 180,
		'6hours'		=> 360,
		'12hours'		=> 720,
		'18hours'		=> 1080,
		'1day'			=> 1440,
		'2days'			=> 2880,
		'3days'			=> 4320,
		'1week'			=> 10080,
		'1month'		=> 43200,
		'1year'			=> 525600,
		'forever'		=> -1,
		default			=> 60,
	};
}

/**
 * Set the background color of the page
 * @return void
 */
function dump_bg()
{
	echo '<style>body { background-color: #18171B; }</style>';
}

/**
 * Call an event without throwing an exception
 *
 * @param mixed $args
 * @return void
 */
function safe_event(...$args)
{
	try {
		event(...$args);
	} catch (\Throwable $th) {
		report($th);
	}
}

/**
 * Call a job without throwing an exception
 *
 * @param mixed $args
 * @return void
 */
function safe_dispatch(...$args)
{
	try {
		dispatch(...$args);
	} catch (\Throwable $th) {
		report($th);
	}
}

/**
 * Get the file hash
 *
 * @param mixed $file_path
 * @return string|false
 */
function get_file_hash($file_path)
{
	return md5_file($file_path);
}

/**
 * Convert a value to boolean
 *
 * @param mixed $value
 * @return mixed
 */
function to_bool($value)
{
	return filter_var($value, FILTER_VALIDATE_BOOLEAN);
}
