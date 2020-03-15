<?php
spl_autoload_register(function ($class) {
    require_once 'core/' . $class . '.php';
});

session_start([
    'cookie_lifetime' => 86400,
]); // включаем/обновляем сессию

Route::start(); // запускаем маршрутизатор