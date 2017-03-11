<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConectionLog
 *
 * @author Alisson
 */
require_once 'DataSource.php';

class ConectionLog extends DataSource {

    private $link;
    private $resultado;

    private function conecta() {
        $this->link = @mysql_connect($this->getHost(), $this->getUserName(), $this->getPassword());
        if (!$this->link) {
            print "Ocorreu um erro na conexao com o banco de dados:";
            die();
        } elseif (!mysql_select_db($this->getDataBase(), $this->link)) {
            print "Ocorreu um Erro em selecionar o Banco:";
            die();
        }
    }

    public function log_sql($user, $query, $origem) {
        if (strtoupper(substr($query, 0, 6)) == "UPDATE") {
            $logQuery = "INSERT INTO log_update (user, query, data, origem)
            VALUES ('$user', '" . $this->retirarAspas($query) . "', '" . date("Y/m/d H:i") . "', '$origem')";
        } else if (strtoupper(substr($query, 0, 6)) == "INSERT") {
            $logQuery = "INSERT INTO log_insert (user, query, data, origem)
            VALUES ('$user', '" . $this->retirarAspas($query) . "', '" . date("Y/m/d H:i") . "', '$origem')";
        } else if (strtoupper(substr($query, 0, 6)) == "DELETE") {
            $logQuery = "INSERT INTO log_delete (user, query, data, origem)
            VALUES ('$user', '" . $resultado . " - " . $this->retirarAspas($query) . "', '" . date("Y/m/d H:i") . "', '$origem')";
        } else {
            $logQuery = "INSERT INTO log_select (user, query, data, origem)
            VALUES ('$user', '" . $this->retirarAspas($query) . "', '" . date("Y/m/d H:i") . "', '$origem')";
        }
        $this->executeUpdate($logQuery);
    }

    public function log_rotina($usuario, $value, $origem) {
        $logQuery = "INSERT INTO log_rotina (user, rotina, data, origem)
            VALUES ('$usuario', '" . $this->retirarAspas($value) . "', '" . date("Y/m/d H:i") . "', '$origem')";
        $this->executeUpdate($logQuery);
    }

    private function executeUpdate($query) {
        $this->conecta();
        if (mysql_query($query)) {
            $this->desconnecta();
        } else {
            $this->desconnecta();
            die();
        }
    }

    private function retirarAspas($frase) {
        return str_replace("'", "", $frase);
    }

    private function desconnecta() {
        return mysql_close($this->link);
    }

}

?>
