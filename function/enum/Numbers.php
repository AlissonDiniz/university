<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Numbers
 *
 * @author Alisson
 */
class Numbers {

    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "1", "nome" => "01");
        $this->opcoes[1] = array("value" => "2", "nome" => "02");
        $this->opcoes[2] = array("value" => "3", "nome" => "03");
        $this->opcoes[3] = array("value" => "4", "nome" => "04");
        $this->opcoes[4] = array("value" => "5", "nome" => "05");
        $this->opcoes[5] = array("value" => "6", "nome" => "06");
        $this->opcoes[6] = array("value" => "7", "nome" => "07");
        $this->opcoes[7] = array("value" => "8", "nome" => "08");
        $this->opcoes[8] = array("value" => "9", "nome" => "09");
        $this->opcoes[9] = array("value" => "10", "nome" => "10");
        return $this->opcoes;
    }

}

?>
