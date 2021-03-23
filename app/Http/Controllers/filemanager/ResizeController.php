<?php

namespace App\Http\Controllers\filemanager;

use App\Events\ImageWasResized;
use Intervention\Image\Facades\Image;
use UniSharp\LaravelFilemanager\Controllers\ResizeController as original;
use UniSharp\LaravelFilemanager\Events\ImageIsResizing;

/**
 * Class ResizeController.
 */
class ResizeController extends original
{
    /**
     * Dipsplay image for resizing.
     *
     * @return mixed
     */
    public function getResize()
    {
        $ratio = 1.0;
        $image = request('img');

        $original_image = Image::make(parent::getCurrentPath($image));
        $original_width = $original_image->width();
        $original_height = $original_image->height();

        $scaled = false;

        // FIXME size should be configurable
        if ($original_width > 600) {
            $ratio = 600 / $original_width;
            $width = $original_width * $ratio;
            $height = $original_height * $ratio;
            $scaled = true;
        } else {
            $width = $original_width;
            $height = $original_height;
        }

        if ($height > 400) {
            $ratio = 400 / $original_height;
            $width = $original_width * $ratio;
            $height = $original_height * $ratio;
            $scaled = true;
        }

        return view('laravel-filemanager::resize')
            ->with('img', parent::objectPresenter(parent::getCurrentPath($image)))
            ->with('height', number_format($height, 0))
            ->with('width', $width)
            ->with('original_height', $original_height)
            ->with('original_width', $original_width)
            ->with('scaled', $scaled)
            ->with('ratio', $ratio);
    }

    public function performResize()
    {
        $dataX = request('dataX');
        $dataY = request('dataY');
        $height = request('dataHeight');
        $width = request('dataWidth');
        $image_path = parent::getCurrentPath(request('img'));

        event(new ImageIsResizing($image_path));
        $hashFileValue = hash_file( 'md5',$image_path ,false);
        Image::make($image_path)->resize($width, $height)->save();
        event(new ImageWasResized($image_path, $hashFileValue));

        return parent::$success_response;
    }
}
