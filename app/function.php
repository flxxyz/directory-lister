<?php

if (!function_exists('v')) {
    /**
     * 构造本程序的主题函数
     * @param string $dir
     * @param array  $data
     */
    function v($dir = '', $data = [])
    {
        $dir = rtrim($dir, '/');
        $theme = \Col\Lib\Config::get('other', 'theme') ?? 'default';
        view("{$theme}/{$dir}", $data);
    }
}

if (!function_exists('_e')) {
    function _e($var = '')
    {
        if (is_object($var) || is_array($var)) {
            var_dump($var);
        } elseif (is_null($var)) {
            var_dump(null);
        } else {
            echo $var;
        }
    }
}

if (!function_exists('run_time')) {
    function run_time($precision = 4)
    {
        $time =
            round(
                microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'],
                $precision
            ) * 1000;
        return $time.'ms';
    }
}