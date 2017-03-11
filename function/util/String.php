<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of String
 *
 * @author Alisson
 */
class String {

    //put your code here
    public function limpaAcentos($value) {
        return strtoupper(ereg_replace("[^a-zA-Z0-9_ ]", "", strtr(trim($value), "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ", "aaaaeeiooouucAAAAEEIOOOUUC")));
    }

    public function lowercase($value) {
        return strtolower($this->limpaAcentos($value));
    }
    
    public function uppercase($value) {
        return strtoupper($this->limpaAcentos($value));
    }

}

?>
