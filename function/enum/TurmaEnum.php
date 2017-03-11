<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TurmaEnum
 *
 * @author Alisson
 */
class TurmaEnum {

    //put your code here
    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "01", "nome" => "01");
        $this->opcoes[1] = array("value" => "02", "nome" => "02");
        $this->opcoes[2] = array("value" => "03", "nome" => "03");
        $this->opcoes[3] = array("value" => "04", "nome" => "04");
        $this->opcoes[4] = array("value" => "05", "nome" => "05");
        $this->opcoes[5] = array("value" => "06", "nome" => "06");
        $this->opcoes[6] = array("value" => "07", "nome" => "07");
        $this->opcoes[7] = array("value" => "08", "nome" => "08");
        $this->opcoes[8] = array("value" => "09", "nome" => "09");
	$this->opcoes[9] = array("value" => "10", "nome" => "10");
	$this->opcoes[10] = array("value" => "11", "nome" => "11");
	$this->opcoes[11] = array("value" => "12", "nome" => "12");
	$this->opcoes[12] = array("value" => "13", "nome" => "13");
	$this->opcoes[13] = array("value" => "14", "nome" => "14");
	$this->opcoes[14] = array("value" => "15", "nome" => "15");
	$this->opcoes[15] = array("value" => "16", "nome" => "16");
	$this->opcoes[16] = array("value" => "17", "nome" => "17");
	$this->opcoes[17] = array("value" => "18", "nome" => "18");
	$this->opcoes[18] = array("value" => "19", "nome" => "19");
	$this->opcoes[19] = array("value" => "20", "nome" => "20");
        return $this->opcoes;
    }

}

?>
