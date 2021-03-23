<?php

namespace App\Events;

class ImageWasCropped
{
    private $path;
    private $hashFileValueOrigin;
    private $crop_path;

    public function __construct($path, $crop_path, $hashFileValueOrigin)
    {
        $this->path = $path;
        $this->crop_path = $crop_path;
        $this->hashFileValueOrigin = $hashFileValueOrigin;
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->path;
    }
    public function crop_path()
    {
        return $this->crop_path;
    }
    public function hashFileValueOrigin()
    {
        return $this->hashFileValueOrigin;
    }
}
