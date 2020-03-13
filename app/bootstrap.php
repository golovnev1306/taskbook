<?php
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/db.php';
require_once 'core/route.php';

session_start([
    'cookie_lifetime' => 86400,
]); // включаем/обновляем сессию

Route::start(); // запускаем маршрутизатор