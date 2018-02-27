<?php
use DirectoryLister\Controller\DirController;

$route->get('/', [DirController::class, 'index']);
$route->get('/*', [DirController::class, 'sub']);
