<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MainService
 *
 * @author Alisson
 */

@session_start();

class MainService {

    public $class;

    public function redirect($url) {
        header("Location: " . $url);
    }

    public function render($controller, $method, $data) {
        $uri = explode("?", $_SERVER['REQUEST_URI']);
        $router = explode("/", $uri[1]);
        $uri = $uri[0] . "?" . $router[0] . "/";
        $action = strtolower(str_replace('Service', '', $controller));
        $classFunction = $this->class;
        include_once $action . '/' . $method . ".php";
    }

}

?>
