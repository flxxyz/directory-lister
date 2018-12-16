<?php $_CONFIG = \Col\Lib\Config::get('other'); ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="version" content="<?=$_CONFIG['version']?>" />
    <title><?=$_CONFIG['title']?></title>
    <meta name="keywords" content="<?=$_CONFIG['keyword']?>" />
    <meta name="description" content="<?=$_CONFIG['description']?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <?php if(http_response_code() == 200): ?>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dplayer/1.25.0/DPlayer.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flv.js/1.5.0/flv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dplayer/1.25.0/DPlayer.min.js"></script>
    <?php endif; ?>
</head>
<body>