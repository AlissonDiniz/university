<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../config/urlmapping.php';
date_default_timezone_set("America/Recife");

$uri = explode("?", $_SERVER['REQUEST_URI']);
if (count($uri) > 1) {
    $router = explode("/", $uri[1]);
    if (count($router) > 0) {
        if (count($router) < 2) {
            include_once '../config/security.php';
        } else {
            $contains = false;
            foreach ($urlAnnonymous as $uri) {
                if (strpos($_SERVER['REQUEST_URI'], $uri) > 0) {
                    $contains = true;
                }
            }
            if (!$contains && $router[1] != "logon" && $router[1] != "auth") {
                include_once '../config/security.php';
            }
        }
        $action = ucfirst($router[0]) . 'Controller';
        if (file_exists("../controller/" . $action . '.php')) {
            require_once "../controller/" . $action . '.php';
            $class = new $action();
            $class->action = $action;
            if (count($router) > 1) {
                $method = "_" . $router[1];
                $params = $_POST;
                if (!$contains && $router[1] != "auth" && $router[1] != "logon") {
                    $params['userCreate'] = $_SESSION['username'];
                }
                if (count($router) > 2) {
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
} else {
    header("Location: " . path);
}
?>
