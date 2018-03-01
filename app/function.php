<?php

if (!function_exists('v')) {
    /**
     * 构造本程序的主题函数
     * @param string $dir
     * @param array  $data
     * @param int    $statusCode
     */
    function v($dir = '', $data = [], $statusCode = 200)
    {
        $dir = rtrim($dir, '/');
        $config = config('config');
        $theme = isset($config['theme']) ? $config['theme'] : 'default';
        view("{$theme}/{$dir}", $data, $statusCode);
    }
}

if (!function_exists('hex_conver')) {
    /**
     * 格式化文件大小输出符合的单位
     * @param int $bit
     * @return string
     */
    function hex_conver($bit = 0)
    {
        if($bit == 0) {
            return '0B';
        }

        $bytes = [
            'TB' => pow(1024, 4),
            'GB' => pow(1024, 3),
            'MB' => pow(1024, 2),
            'KB' => 1024,
            'B'  => 1,
        ];

        foreach ($bytes as $name => $value) {
            $n = intval($bit) / $value;
            if (0 != $c = floor($n)) {
                return round($n, 2) . $name;
            }
        }
    }
}
