<?php

namespace App\Http\Controllers\filemanager;

use UniSharp\LaravelFilemanager\Controllers\CropController as original;

/**
 * Class DownloadController.
 */

class DownloadController extends original {
	/**
	 * Download a file.
	 *
	 * @return mixed
	 */
	public function getDownload() {
		ob_end_clean();
		return response()->download(parent::getCurrentPath(request('file')));
	}
}
