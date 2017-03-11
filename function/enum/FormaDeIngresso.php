<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormaDeIngresso
 *
 * @author Alisson
 */
class FormaDeIngresso {

    //put your code here
    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "0", "nome" => "Processo Seletivo");
        $this->opcoes[1] = array("value" => "1", "nome" => "Vestibular");
        $this->opcoes[2] = array("value" => "2", "nome" => "Transferência");
        $this->opcoes[3] = array("value" => "3", "nome" => "Mudança de Curso");
        $this->opcoes[4] = array("value" => "4", "nome" => "Graduado");
        $this->opcoes[5] = array("value" => "5", "nome" => "Outros");
        return $this->opcoes;
    }

}

?>
