<?php

namespace App\Services\Tools;

/* @class service curl http service */
class FileService
{
    public function saveFile(string $directory, $output) : ?bool
    {
        file_put_contents($directory, $output);
        return true;
    }
}

