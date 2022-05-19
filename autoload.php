<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-05-18 08:51:59
 * @modify date 2022-05-18 15:32:58
 * @license GPLv3
 * @desc [description]
 */

include __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/helper.php';

spl_autoload_register(function($class) {
    $class = str_replace('SLiMSOAuth\\', '', $class);
    $paths = explode('\\', $class);
    $fixPath = [];
    foreach ($paths as $index => $path) {
        if ($index === 0)
        {
            $fixPath[] = ucfirst($path);
        }
        else
        {
            $fixPath[] = $path;
        }
    }

    $truePath = __DIR__ . DS . implode(DS, $fixPath) . '.php';
    
    if (file_exists($truePath))
    {
        include $truePath;
    }
});