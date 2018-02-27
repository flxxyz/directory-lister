<?php

if (!function_exists('v')) {
    function v($dir = '', $data = [], $statusCode = 200)
    {
        $dir = rtrim($dir, '/');
        $config = config('config');
        view("{$config['theme']}/{$dir}", $data, $statusCode);
    }
}
