<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SituacaoDisciplina
 *
 * @author Alisson
 */
class SituacaoDisciplina {

    //put your code here
    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "EC", "nome" => "Em Curso");
        $this->opcoes[1] = array("value" => "AP", "nome" => "Aprovado");
        $this->opcoes[2] = array("value" => "RE", "nome" => "Reprovado");
        $this->opcoes[3] = array("value" => "RF", "nome" => "Repr p/ Faltas");
        $this->opcoes[4] = array("value" => "TR", "nome" => "Trancado");
        $this->opcoes[5] = array("value" => "DI", "nome" => "Dispensado");
        $this->opcoes[6] = array("value" => "CO", "nome" => "Complemento");
        $this->opcoes[7] = array("value" => "PE", "nome" => "Pendente");
        return $this->opcoes;
    }

}

?>
