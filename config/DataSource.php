<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataSource
 *
 * @author Alisson
 */
class DataSource {

    private $dataBase = "localhost:netting:netting_bd:netting_bd";

    private function decode($key) {
        $arrayDataBase = explode(":", $this->dataBase);
        return $arrayDataBase[$key];
    }

    public function getHost() {
        return $this->decode(0);
    }

    public function getDataBase() {
        return $this->decode(1);
    }

    public function getUserName() {
        return $this->decode(2);
    }

    public function getPassword() {
        return $this->decode(3);
    }

}

?>
