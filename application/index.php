<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../config/security.php';
require_once '../config/ConectionLog.php';
require_once '../controller/MainController.php';

$conexaoLog = new ConectionLog();
$uri = explode("?", $_SERVER['REQUEST_URI']);
$conexaoLog->log_rotina($_SESSION['username'], $_SERVER['REQUEST_URI'], $_SERVER['REMOTE_ADDR']);
if (count($uri) > 1) {
    if (!strpos($uri[1], "?=&page=")) {
        if (strpos($uri[1], "=&page=")) {
            header("Location: " . str_replace("=&page=", "?=&page=", $_SERVER['REQUEST_URI']));
        }
    }
    $router = explode("/", $uri[1]);
    if (count($router) > 0) {
        $action = ucfirst($router[0]) . 'Controller';
        if (file_exists("../controller/" . $action . '.php')) {
            require_once "../controller/" . $action . '.php';
            $class = new $action();
            $class->action = $action;

            if (count($router) > 1) {
                $method = "_" . $router[1];
                $params = $_POST;
                $params['userCreate'] = $_SESSION['username'];
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
                $classMethods = get_class_methods($class);
                if (in_array($method, $classMethods)) {
                    if ($class->getAuthority($method) <= $_SESSION['autoridade']) {
                        $class->method = $method;
                        $class->$method();
                    } else {
                        $class->_denied();
                        die();
                    }
                } else {
                    echo "<h1>PAGE NOT FOUND - 404</h1>";
                    die();
                }
            } else {
                if ($class->getAuthority("_index") <= $_SESSION['autoridade']) {
                    $class->_index();
                } else {
                    $class->_denied();
                    die();
                }
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
