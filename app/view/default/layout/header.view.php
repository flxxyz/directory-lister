<?php $_CONFIG = config('config'); ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="version" content="<?php _e($_CONFIG['version']) ?>" />
    <title><?php _e(isset($title) ? $title . ' | ' : '') ?><?php _e($_CONFIG['title']) ?></title>
    <meta name="keywords" content="<?php _e(isset($keyword) ? $keyword . ',' : '') ?><?php _e($_CONFIG['keyword']) ?>" />
    <meta name="description" content="<?php _e(isset($description) ? $description : $_CONFIG['description']) ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <?php if(http_response_code() == 200): ?>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
        <link href="https://cdn.bootcss.com/bulma/0.6.2/css/bulma.min.css" rel="stylesheet">
    <?php endif; ?>
</head>
<body>