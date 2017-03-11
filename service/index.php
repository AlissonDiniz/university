<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../config/urlmapping.php';
include_once 'main/MainService.php';

$uri = explode("?", $_SERVER['REQUEST_URI']);
if (count($uri) > 1) {
    $router = explode("/", $uri[1]);
    if (count($router) > 0) {
        $action = ucfirst($router[0]) . "Service";
        if (file_exists($router[0] . "/" . $action . '.php')) {
            require_once $router[0] . "/" . $action . '.php';
            $class = new $action();
            $class->action = $action;
            if (count($router) > 1) {
                $method = "_" . $router[1];
                $params = $_POST;
                if (count($router) > 2 || count($uri) > 2) {
                    if (count($uri) > 2) {
                        $arrayParams = explode("&", $uri[2]);
                        foreach ($arrayParams as $value) {
                            $arrayParametro = explode("=", $value);
                            $params[$arrayParametro[0]] = $arrayParametro[1];
                        }
                    } else {
                        $params['id'] = $router[2];
                    }
                }
                if (!empty($params)) {
                    $class->params = $params;
                }
                
                if(!empty($params['user'])){
                    $_SESSION['username'] = $params['user'];
                }else{
                    $_SESSION['username'] = "ANONYMOUS_SERVICE";
                }
                
                $classMethods = get_class_methods($class);
                if (in_array($method, $classMethods)) {
                    $class->method = $method;
                    $class->$method();
                } else {
                    echo "<h1>PAGE NOT FOUND - 404</h1>";
                    die();
                }
            } else {
                $class->_index();
            }
        } else {
            echo "<h1>PAGE NOT FOUND - 404</h1>";
            die();
        }
    } else {
        header("Location: " . path);
    }
}
?>
