<?php

namespace App\Services\Utils;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

class FileUtilService
{
    public function listFileInDirectory(string $dirPath, string $regex = null) : array
    {
        $Directory = new RecursiveDirectoryIterator('path/to/project/');
        $Iterator = new RecursiveIteratorIterator($Directory);
        if (\is_null($regex)){
            return new RegexIterator($Iterator, "/^.+$/i", RecursiveRegexIterator::GET_MATCH);
        }
        else{
            return new RegexIterator($Iterator, $regex, RecursiveRegexIterator::GET_MATCH);
        }
    }
}
