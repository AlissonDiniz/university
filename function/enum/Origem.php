<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Origem
 *
 * @author Alisson
 */
class Origem {

    //put your code here
    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "1", "nome" => "Financeiro");
        $this->opcoes[1] = array("value" => "2", "nome" => "Biblioteca");
        $this->opcoes[2] = array("value" => "3", "nome" => "Acadêmico");
        return $this->opcoes;
    }

}

?>
