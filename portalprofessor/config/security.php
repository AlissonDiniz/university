<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
@session_start();
include_once 'urlmapping.php';

if ($_SESSION["system"] != "SYSMAPORTALPROFESSOR") {
    header("Location: " . application . "account/auth");
    die();
} else {
    if (empty($_SESSION["id"]) || empty($_SESSION["username"])) {
        header("Location: " . application . "account/auth");
        die();
    } else {
        if (!$_SESSION["logged"]) {
            header("Location: " . application . "account/auth");
            die();
        }
    }
}
?>
