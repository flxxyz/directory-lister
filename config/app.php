<?php

return [
    /**
     * 时区设置
     */
    'timezone' => 'PRC',
    /**
     * ajax允许访问的域
     */
    'allow_origins' => [
        'http://127.0.0.1',
    ],
    /**
     * ajax允许访问的请求方法
     */
    'allow_methods' => '*',
    /**
     * 日志设置
     */
    'log' => [
        /**
         * 存放目录(绝对路径)
         */
        'dir' => BASE_DIR . 'log' . DS,
        /**
         * 日志内容格式
         */
        'format' => 'D H:i:s u',
    ],
    /**
     * 错误页面设置
     */
    'error_page' => [
        '404' =>  VIEW_DIR . 'error/404.view.php',
    ]
];
