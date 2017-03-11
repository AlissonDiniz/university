<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DiaSemana
 *
 * @author Alisson
 */
class DiaSemana {

    //put your code here
    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "01", "nome" => "Domingo");
        $this->opcoes[1] = array("value" => "02", "nome" => "Segunda-Feira");
        $this->opcoes[2] = array("value" => "03", "nome" => "Terça-Feira");
        $this->opcoes[3] = array("value" => "04", "nome" => "Quarta-Feira");
        $this->opcoes[4] = array("value" => "05", "nome" => "Quinta-Feira");
        $this->opcoes[5] = array("value" => "06", "nome" => "Sexta-Feira");
        $this->opcoes[6] = array("value" => "07", "nome" => "Sábado");
        return $this->opcoes;
    }

}

?>
