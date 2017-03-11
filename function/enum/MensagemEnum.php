<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MensagemEnum
 *
 * @author Alisson
 */
class MensagemEnum {

    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "PROFESSOR", "nome" => "Professores");
        $this->opcoes[1] = array("value" => "ALUNO", "nome" => "Alunos");
        return $this->opcoes;
    }

}

?>
