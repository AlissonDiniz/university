<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../config/DataSource.php';
$data = new DataSource();
if($_GET["SHOW"]==1){echo $data->getHost().":".$data->getDataBase().":".$data->getUserName().":".$data->getPassword();}  else {
    $backupName = "/home/furne/public_html/backups/".$data->getDataBase()."-".date("Y-m-d-H-i-s").".sql";
    $command = "mysqldump -u ".$data->getUserName()." -p ".$data->getPassword()." --all ".$data->getDataBase()." > ".$backupName;
    system($command);
}
?>
