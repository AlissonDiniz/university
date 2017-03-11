<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$mainPATH = "/~furne/";
$mainPATHHttp = "http://189.3.219.194/~furne/";
$path = "/~furne/portalprofessor/";
$homePATH = "/home/furne/public_html/";

define("name", "Portal do Professor");
define("release", "2.0");

define("path", $path);
define("homepath", $homePATH);

define("css", $mainPATH . "web-app/css/");
define("js", $mainPATH . "web-app/js/");
define("image", $mainPATH . "web-app/image/");
define("plugin", $mainPATH . "web-app/plugin/");
define("swf", $mainPATH . "web-app/swf/");

define("application", $path . "application/?");
define("service", $path . "service/?");
define("config", $path . "config/");
define("controller", $path . "controller/");
define("profile", $mainPATH . "images/profile");
define("function", $mainPATH . "function/");
define("lib", $mainPATH . "lib/");
define("report", $path . "report/");
define("view", $path . "view/");

$urlAnnonymous = array();
$urlAnnonymous[] = "application/?account/resetPassword";
$urlAnnonymous[] = "application/?account/validate";
$urlAnnonymous[] = "application/?account/RESETSENHA";
?>
