<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SituacaoTitulo
 *
 * @author Alisson
 */
class SituacaoTitulo {

    //put your code here
    public $opcoes;

    public function loadOpcoes() {
        $this->opcoes[0] = array("value" => "B", "nome" => "Baixado Total");
        $this->opcoes[1] = array("value" => "A", "nome" => "Aberto");
        $this->opcoes[2] = array("value" => "P", "nome" => "Baixado Parcial");
        $this->opcoes[3] = array("value" => "V", "nome" => "<span style='color: #FF0000'>Vencido</span>");
        return $this->opcoes;
    }

}

?>
