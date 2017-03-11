<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Formula
 *
 * @author Alisson
 */
class Formula {

    //put your code here
    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "1CF", "nome" => "1 Unidade - C/ Final");
        $this->opcoes[1] = array("value" => "2CF", "nome" => "2 Unidades - C/ Final");
        $this->opcoes[2] = array("value" => "3CF", "nome" => "3 Unidades - C/ Final");
        $this->opcoes[3] = array("value" => "4CF", "nome" => "4 Unidades - C/ Final");
        $this->opcoes[4] = array("value" => "5CF", "nome" => "5 Unidades - C/ Final");
        $this->opcoes[5] = array("value" => "6CF", "nome" => "6 Unidades - C/ Final");
        $this->opcoes[6] = array("value" => "7CF", "nome" => "7 Unidades - C/ Final");
        $this->opcoes[7] = array("value" => "8CF", "nome" => "8 Unidades - C/ Final");
        $this->opcoes[8] = array("value" => "1SF", "nome" => "1 Unidade - S/ Final");
        $this->opcoes[9] = array("value" => "2SF", "nome" => "2 Unidades - S/ Final");
        $this->opcoes[10] = array("value" => "3SF", "nome" => "3 Unidades - S/ Final");
        $this->opcoes[11] = array("value" => "4SF", "nome" => "4 Unidades - S/ Final");
        $this->opcoes[12] = array("value" => "5SF", "nome" => "5 Unidades - S/ Final");
        $this->opcoes[13] = array("value" => "6SF", "nome" => "6 Unidades - S/ Final");
        $this->opcoes[14] = array("value" => "7SF", "nome" => "7 Unidades - S/ Final");
        $this->opcoes[15] = array("value" => "8SF", "nome" => "8 Unidades - S/ Final");
        return $this->opcoes;
    }

}

?>
