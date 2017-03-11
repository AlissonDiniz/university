<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FaltaEnum
 *
 * @author Alisson
 */
class FaltaEnum {

    //put your code here
    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "P", "nome" => "Presença");
        $this->opcoes[1] = array("value" => "F", "nome" => "Falta");
        $this->opcoes[2] = array("value" => "A", "nome" => "Atestado");
        return $this->opcoes;
    }

}

?>
