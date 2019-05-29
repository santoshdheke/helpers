<?php

function folder_exist($folder)
{
    $path = realpath($folder);
    if ($path !== false AND is_dir($path)) {
        return $path;
    }
    return false;
}

function makeDir($dir)
{
    if(!(folder_exist($dir))){
        mkdir($dir, 0777, true);
    }
}