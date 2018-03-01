<?php

// 是否开启debug模式
define('APP_DEBUG', true, true);

// 是否开启session（默认关闭）
define('SESSION_OPEN', false, true);

define('DS', DIRECTORY_SEPARATOR, true);
define('SITE_DIR', realpath(__DIR__) . DS, true);
define('APP_DIR', realpath(SITE_DIR . '../app') . DS, true);
define('BASE_DIR', realpath(SITE_DIR . '..') . DS, true);

if (intval(PHP_VERSION) < 7) {
    $str = '<h3>PHP版本小于7.0，请切换大于或等于7.0的版本</h3>';
    $str .= '现在是2018年了！！！';
    exit($str);
}

require_once APP_DIR . 'function.php';
require_once BASE_DIR . 'bootstrap/app.php';
