<?php

//引入自动加载文件
require_once __DIR__ . '/../vendor/autoload.php';

use Col\{
    Route,
    Lib\Config
};

//设置脚本时区
ini_set('date.timezone', Config::get('app', 'timezone'));

//实例路由
Route::make(\request());

//引入路由列表
require_once BASE_DIR . 'route/web.php';

//路由完成
Route::end();