<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SituacaoAluno
 *
 * @author Alisson
 */
class SituacaoAluno {

    //put your code here
    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "ME", "nome" => "Matriculado");
        $this->opcoes[1] = array("value" => "MD", "nome" => "Mudança de Curso");
        $this->opcoes[4] = array("value" => "TR", "nome" => "Transferido");
        $this->opcoes[5] = array("value" => "CL", "nome" => "Cancelado");
        $this->opcoes[6] = array("value" => "FA", "nome" => "Falecido");
        return $this->opcoes;
    }

}

?>
