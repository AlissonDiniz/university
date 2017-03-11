<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
header ('Content-type: text/html; charset=UTF-8');

$pathHttp = "http://54.165.87.106/netting/";
$path = "/netting/";
$homepath = "C:\\inetpub\wwwroot\\netting\\";

define("name", "Netting");
define("release", "2.0");

define("path", $path);
define("pathHttp", $pathHttp);
define("homepath", $homepath);
define("uriRemessa", $homepath . "bank_files/remessa/");
define("uriRetorno", $homepath . "bank_files/retorno/");
define("uriBackups", $homepath . "backups/");

define("css", $path . "web-app/css/");
define("js", $path . "web-app/js/");
define("image", $path . "web-app/image/");
define("imageHttp", $pathHttp . "web-app/image/");
define("plugin", $path . "web-app/plugin/");
define("swf", $path . "web-app/swf/");

define("applicationHttp", $pathHttp . "application/?");
define("application", $path . "application/?");
define("service", $path . "service/?");
define("serviceHttp", $pathHttp . "service/?");
define("config", $path . "config/");
define("controller", $path . "controller/");
define("profile", $path . "images/profile");
define("function", $path . "function/");
define("lib", $path . "lib/");
define("report", $path . "report/");
define("view", $path . "view/");

?>
