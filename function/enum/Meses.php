<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Meses
 *
 * @author Alisson
 */
class Meses {

    //put your code here
    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "01", "nome" => "Janeiro");
        $this->opcoes[1] = array("value" => "02", "nome" => "Fevereiro");
        $this->opcoes[2] = array("value" => "03", "nome" => "Março");
        $this->opcoes[3] = array("value" => "04", "nome" => "Abril");
        $this->opcoes[4] = array("value" => "05", "nome" => "Maio");
        $this->opcoes[5] = array("value" => "06", "nome" => "Junho");
        $this->opcoes[6] = array("value" => "07", "nome" => "Julho");
        $this->opcoes[7] = array("value" => "08", "nome" => "Agosto");
        $this->opcoes[8] = array("value" => "09", "nome" => "Setembro");
        $this->opcoes[9] = array("value" => "10", "nome" => "Outubro");
        $this->opcoes[10] = array("value" => "11", "nome" => "Novembro");
        $this->opcoes[11] = array("value" => "12", "nome" => "Dezembro");
        return $this->opcoes;
    }

}

?>
