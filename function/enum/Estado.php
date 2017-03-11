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
class Estado {

    //put your code here
    public $estados;

    public function loadEstados() {
        $this->estados[0] = array("value" => "AC", "nome" => "Acre");
        $this->estados[1] = array("value" => "AL", "nome" => "Alagoas");
        $this->estados[2] = array("value" => "AP", "nome" => "Amapá");
        $this->estados[3] = array("value" => "AM", "nome" => "Amazonas");
        $this->estados[4] = array("value" => "BA", "nome" => "Bahia");
        $this->estados[5] = array("value" => "CE", "nome" => "Ceará");
        $this->estados[6] = array("value" => "DF", "nome" => "Distrito Federal");
        $this->estados[7] = array("value" => "ES", "nome" => "Espirito Santo");
        $this->estados[8] = array("value" => "GO", "nome" => "Goiás");
        $this->estados[9] = array("value" => "MA", "nome" => "Maranhão");
        $this->estados[10] = array("value" => "MS", "nome" => "Mato Grosso do Sul");
        $this->estados[11] = array("value" => "MT", "nome" => "Mato Grosso");
        $this->estados[12] = array("value" => "MG", "nome" => "Minas Gerais");
        $this->estados[13] = array("value" => "PA", "nome" => "Pará");
        $this->estados[14] = array("value" => "PB", "nome" => "Paraíba");
        $this->estados[15] = array("value" => "PR", "nome" => "Paraná");
        $this->estados[16] = array("value" => "PE", "nome" => "Pernambuco");
        $this->estados[17] = array("value" => "PI", "nome" => "Piauí");
        $this->estados[18] = array("value" => "RJ", "nome" => "Rio de Janeiro");
        $this->estados[19] = array("value" => "RN", "nome" => "Rio Grande do Norte");
        $this->estados[20] = array("value" => "RS", "nome" => "Rio Grande do Sul");
        $this->estados[21] = array("value" => "RO", "nome" => "Rondônia");
        $this->estados[22] = array("value" => "RR", "nome" => "Roraima");
        $this->estados[23] = array("value" => "SA", "nome" => "Santa Catarina");
        $this->estados[24] = array("value" => "SP", "nome" => "São Paulo");
        $this->estados[25] = array("value" => "SE", "nome" => "Sergipe");
        $this->estados[26] = array("value" => "TO", "nome" => "Tocantins");
        return $this->estados;
    }

}

?>
