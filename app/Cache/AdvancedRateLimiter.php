<?php

namespace App\Cache;

use Illuminate\Cache\RateLimiter;

class AdvancedRateLimiter extends RateLimiter {
	/**
	 * Determine if the given key has been "accessed" too many times.
	 *
	 * @param  string  $key
	 * @param  int  $maxAttempts
	 * @return bool
	 */
	public function tooManyAttempts($key, $maxAttempts) {
		var_dump($this->attempts($key));
		if ($this->attempts($key) >= $maxAttempts) {
			if ($this->cache->has($key . ':timer')) {

				$this->resetAttempts($key);
				return true;
			}
		}

		return false;
	}

}