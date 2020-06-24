<?php

class Route
{
	static function start()
	{
		global $settings;
        $controller = 'main';
        $action = 'index';
        $routes = explode("/", $_SERVER['REQUEST_URI']);
        if(count($routes) == 2){
            if(!empty($routes[1])){
                $action = strtolower($routes[1]);
            }
        } else {
            if(!empty($routes[1])){
                $controller = strtolower($routes[1]);
            }

            if(!empty($routes[2])){
                $action = strtolower($routes[2]);
            }
        }

        $controllerName = "{$controller}Controller";
        $controllerPath = "{$_SERVER['DOCUMENT_ROOT']}/app/controllers/{$controllerName}.php";
        $action = explode("?", $action)[0]; // отделяем GET-параметры от action
        $actionName = "{$action}Action";
        if(file_exists($controllerPath)){
            include $controllerPath;
            $controller = new $controllerName();
            if(method_exists($controller, $actionName)){
                $controller->$actionName();
            } else {
                Route::Error404();
            }       
        } else {
            Route::Error404();
        }
    }

    static function Error404(){
        $host = 'http://' . $_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:' . $host . 'page404');
    }
}