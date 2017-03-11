<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$id = base64_decode($_GET['id']);

if (!$id == '') {
    if (!file_exists("foto_" . $id . ".png")) {
        $filename = "no-user.png";
    } else {
        $filename = "foto_" . $id . ".png";
    }
} else {
    $filename = "no-user.png";
}

$image = fopen($filename, 'rb');
header("Content-Type: image/png");
header("Content-Length: " . filesize($filename));
fpassthru($image);
?>