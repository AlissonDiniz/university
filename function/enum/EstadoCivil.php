<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Estado
 *
 * @author Alisson
 */
class EstadoCivil {

    //put your code here
    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "SO", "nome" => "Solteiro");
        $this->opcoes[1] = array("value" => "CA", "nome" => "Casado");
        $this->opcoes[2] = array("value" => "DI", "nome" => "Divorciado");
        $this->opcoes[3] = array("value" => "VI", "nome" => "Vuivo");
        $this->opcoes[4] = array("value" => "OU", "nome" => "Outros");
        return $this->opcoes;
    }

}

?>
