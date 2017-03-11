<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conection
 *
 * @author Alisson
 */
require_once 'DataSource.php';
require_once 'ConectionLog.php';

class Conection extends DataSource {

    private $link;
    private $resultado;
    public $conectionLog;

    public function Conection() {
        $this->conectionLog = new ConectionLog();
    }

    private function conecta() {
        $this->link = @mysql_connect($this->getHost(), $this->getUserName(), $this->getPassword());
        if (!$this->link) {
            print "Ocorreu um erro na conexao com o banco de dados:";
            die();
        } else {
            //mysql_set_charset('utf8', $this->link);
            if (!mysql_select_db($this->getDataBase(), $this->link)) {
                print "Ocorreu um Erro em selecionar o Banco:";
                die();
            }
        }
    }

    public function selectQuery($query) {
        $this->conectionLog->log_sql($_SESSION["username"], $query, $_SERVER["REMOTE_ADDR"]);
        $query = $this->preparedStatement($query);
        $this->conecta();
        if ($this->resultado = mysql_query($query)) {
            $this->desconnecta();
            return $this->resultado;
        } else {
            $this->desconnecta();
            return null;
        }
    }

    public function executeUpdate($query) {

        if (strtoupper(substr($query, 0, 6)) == "DELETE") {
            $this->conecta();
            $logQuery = str_replace("DELETE", "SELECT *", $query);
            if ($this->resultado = mysql_query($logQuery)) {
                $this->desconnecta();
            } else {
                $this->desconnecta();
                die();
            }
            $this->conectionLog->log_sql($_SESSION["username"], $query . " = " . $this->cleanString(implode("-", $this->fetch($this->resultado))), $_SERVER["REMOTE_ADDR"]);
        } else {
            $this->conectionLog->log_sql($_SESSION["username"], $query, $_SERVER["REMOTE_ADDR"]);
        }

        $this->conecta();
        $query = $this->preparedStatement($query);

        if (mysql_query($query)) {
            $this->desconnecta();
            return true;
        } else {
            $this->desconnecta();
            return false;
        }
    }

    private function preparedStatement($query) {
        if (preg_match('/^\s*DELETE\s+FROM\s+(\S+)\s*$/i', $query)) {
            $query = preg_replace("/^\s*DELETE\s+FROM\s+(\S+)\s*$/", "DELETE FROM \\1 WHERE 1=1", $query);
        }
        return $query;
    }

    private function desconnecta() {
        return mysql_close($this->link);
    }

    public function fetch($result) {
        $matrix = mysql_fetch_array($result);
        return $matrix;
    }

    public function rows($result) {
        $value = mysql_num_rows($result);
        return $value;
    }

    public function cleanString($value) {
        return strtoupper(preg_replace("/[^a-zA-Z0-9_ -]/", "", strtr(trim($value), "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ", "aaaaeeiooouucAAAAEEIOOOUUC")));
    }

}

?>
