<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Turno
 *
 * @author Alisson
 */
class Turno {

    //put your code here
    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "M", "nome" => "Manhã");
        $this->opcoes[1] = array("value" => "T", "nome" => "Tarde");
        $this->opcoes[2] = array("value" => "N", "nome" => "Noite");
        $this->opcoes[3] = array("value" => "I", "nome" => "Integral");
        return $this->opcoes;
    }

}

?>
