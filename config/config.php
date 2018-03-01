<?php
/**
 * 程序的主要配置
 * @version 0.0.1
 */
return [
    'version'     => '0.0.1',            // 版本
    'title'       => 'DirectoryLister',  // 站点标题
    'keyword'     => 'DirectoryLister',  // 站点关键字
    'description' => 'DirectoryLister',  // 站点描述
    'timezone'    => 'PRC',              // 时区
    'theme'       => 'default',          // 主题名（view目录下）
    'date_format' => 'Y-m-d H:i:s',      // 日期格式
    'root_path'   => '/',                // 根目录
    'data_path'   => '/data/www/wwwroot/directory-lister',  // **需要显示列表的目录**
    // 忽略文件列表（.与..由程序自动忽略）
    'ignore_list' => [
        '.htaccess',
        'Thumbs.db',
        '.DS_Store',
        '.user.ini',
        '.gitignore',
        'index.php',
        'robots.txt',
        '.babelrc',
        '.idea',
        '.git',
        '$RECYCLE.BIN',
        '.Spotlight-V100',
        '.Trashes',
        '.fseventsd',
        'System Volume Information',
    ],
];