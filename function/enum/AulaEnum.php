<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AulaEnum
 *
 * @author Alisson
 */
class AulaEnum {

    //put your code here
    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "1", "nome" => "1 Aula");
        $this->opcoes[1] = array("value" => "2", "nome" => "2 Aulas");
        $this->opcoes[2] = array("value" => "3", "nome" => "3 Aulas");
        $this->opcoes[3] = array("value" => "4", "nome" => "4 Aulas");
        $this->opcoes[4] = array("value" => "5", "nome" => "5 Aulas");
        $this->opcoes[5] = array("value" => "6", "nome" => "6 Aulas");
        $this->opcoes[6] = array("value" => "7", "nome" => "7 Aulas");
        $this->opcoes[7] = array("value" => "8", "nome" => "8 Aulas");
        $this->opcoes[8] = array("value" => "9", "nome" => "9 Aulas");
        $this->opcoes[9] = array("value" => "10", "nome" => "10 Aulas");
        return $this->opcoes;
    }

}

?>
