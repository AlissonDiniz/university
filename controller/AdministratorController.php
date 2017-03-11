<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdministratorController
 *
 * @author Alisson
 */
include_once '../config/DataSource.php';
include_once '../config/urlmapping.php';

class AdministratorController extends MainController {

    public $action;
    public $method;
    public $params;

    public function AcademicoController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_bkp", "authority" => 4);
    }

    public function _index() {
        $this->_backup();
    }

    public function _backup() {
        $dataSource = new DataSource();
        mysql_connect($dataSource->getHost(), $dataSource->getUserName(), $dataSource->getPassword()) or die(mysql_error());
        mysql_select_db($dataSource->getDataBase()) or die(mysql_error());
        $file = fopen(uriBackups . "SYSMA-FURNE-" . date("Y.m.d") . ".sql", "w");
        $scriptShowTables = "SHOW TABLES FROM " . $dataSource->getDataBase();
        $arrayTables = mysql_query($scriptShowTables);

        while ($table = mysql_fetch_row($arrayTables)) {
            $nameTable = $table[0];
            $scriptCreateTable = mysql_query("SHOW CREATE TABLE $nameTable");
            while ($lineCreateTable = mysql_fetch_row($scriptCreateTable)) {
                fwrite($file, "-- CREATE TABLE: $nameTable\n");
                $savedLine = fwrite($file, "$lineCreateTable[1]\n\n-- INSERT DATA\n");
                $arrayLinesTable = mysql_query("SELECT * FROM $nameTable");

                while ($lineTable = mysql_fetch_row($arrayLinesTable)) {
                    $scriptLineTable = "INSERT INTO $nameTable VALUES ('";
                    $scriptLineTable .= implode("', '", $lineTable);
                    $scriptLineTable .= "')\n";
                    fwrite($file, $scriptLineTable);
                }
                fwrite($file, "\n\n");
            }
        }

        $closedFile = fclose($file);

        if ($closedFile) {
            echo "Backup completed successfully!!";
        } else {
            echo "Error create backup!!";
        }
    }

}

?>
