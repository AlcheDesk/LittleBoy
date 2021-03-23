<?php

namespace App\Events;

class ImageWasResized
{
    private $path;
    private $hashFileValue;

    public function __construct($path, $hashFileValue)
    {
        $this->path = $path;
        $this->hashFileValue =$hashFileValue;
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    public function hashFileValue()
    {
        return $this->hashFileValue;
    }
}
