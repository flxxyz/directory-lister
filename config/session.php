<?php
/**
 * session基本配置
 * @version 0.0.1
 */
return [
    'open'    => false,
    'expire'  => 360, // 单位: 分钟
    'limiter' => 'private',
    'perfix'  => 'DirectoryLister',
];
