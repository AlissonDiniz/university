<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SituacaoPeriodo
 *
 * @author Alisson
 */
class SituacaoPeriodo {

    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "ME", "nome" => "Matriculado");
        $this->opcoes[1] = array("value" => "PM", "nome" => "Pré-Matriculado");
        $this->opcoes[2] = array("value" => "MT", "nome" => "Matricula Trancada");
        return $this->opcoes;
    }

}

?>
