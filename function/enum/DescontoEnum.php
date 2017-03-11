<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DescontoEnum
 *
 * @author Alisson
 */
class DescontoEnum {

    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[3] = array("value" => "NINCIDE-0", "nome" => "Não Incide no Valor");
        $this->opcoes[2] = array("value" => "INCIDE-1", "nome" => "Incide no Valor");
        $this->opcoes[0] = array("value" => "FIES-1", "nome" => "FIES");
        $this->opcoes[1] = array("value" => "PROUNI-1", "nome" => "Prouni");
        return $this->opcoes;
    }

}

?>
