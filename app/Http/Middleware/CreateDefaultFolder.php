<?php

namespace App\Http\Middleware;

use Closure;
use UniSharp\LaravelFilemanager\Traits\LfmHelpers;

class CreateDefaultFolder {
	use LfmHelpers;

	public function handle($request, Closure $next) {
		$this->checkDefaultFolderExists('user');
		$this->checkDefaultFolderExists('share');

		return $next($request);
	}

	private function checkDefaultFolderExists($type = 'share') {
		if ($type === 'user' && !$this->allowMultiUser()) {
			return;
		}

		if ($type === 'share' && !$this->allowShareFolder()) {
			return;
		}

		$path = $this->getRootFolderPath($type);

		$default_folder = config('lfm.default_folders');

		foreach ($default_folder as $value) {
			$dir_path = $path . '/' . $value;
			$this->createFolderByPath($dir_path);
		}

	}
}
