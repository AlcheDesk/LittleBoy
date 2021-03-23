<?php

namespace App\Events;

class ImageWasDeleted
{
    private $path;
    private $hashFileValue;

    public function __construct($path,$hashFileValue)
    {
        $this->path = $path;
        $this->hashFileValue = $hashFileValue;
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function hashFileValue()
    {
        return $this->hashFileValue;
    }
}
