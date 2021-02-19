<?php
    require_once('core/autoload.php');

    $requestUri=preg_split('/\/|\?/',$_SERVER["REQUEST_URI"]);
    // var_dump($requestUri);
    // die();
    $controllerName = !isset($requestUri[1]) ? 'user' : $requestUri[1] === '' ? 'user' : $requestUri[1];
    $actionName = !isset($requestUri[2]) ? 'index' : $requestUri[2] === '' ? 'index' : $requestUri[2];
    $controllerPath ='controllers/' . $controllerName . 'Controller.php';

    try
    {
        if (file_exists($controllerPath)){
            $controllerClassName = '\\controllers\\' . $controllerName . 'Controller';
            $controller = new $controllerClassName;
            $actionClassMethodName = $actionName . 'Action';
            if (method_exists($controller, $actionClassMethodName)){
                $controller->$actionClassMethodName();
            } else {
                throw new Exception ("Method $actionClassMethodName in controller class $controllerClassName not found in file: $controllerPath");
            }
        } else {
            throw new Exception ("Controller file not found file name: $controllerPath");
        }
    } catch (Exception $ex) {
        echo $error = $ex->getMessage();
        require_once ('views/_shared/error.php');
    }