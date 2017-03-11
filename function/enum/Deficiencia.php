<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Deficiencia
 *
 * @author Alisson
 */
class Deficiencia {

    //put your code here
    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "NP", "nome" => "Não possui Deficiência");
        $this->opcoes[1] = array("value" => "DF", "nome" => "Deficiência Física");
        $this->opcoes[2] = array("value" => "DA", "nome" => "Deficiência Auditiva");
        $this->opcoes[3] = array("value" => "DV", "nome" => "Deficiência Visual");
        return $this->opcoes;
    }

}

?>
