<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Format
 *
 * @author Alisson
 */
class Format {

    public function stringCompleteLeft($value, $qtd, $char) {
        $restante = $qtd - strlen($value);
        for ($i = 0; $i < $restante; $i++) {
            $value = $char . $value;
        }
        return $value;
    }

    public function stringCompleteRight($value, $qtd, $char) {
        $restante = $qtd - strlen($value);
        for ($i = 0; $i < $restante; $i++) {
            $value = $char . $value;
        }
        return $value;
    }

    public function cleanNumber($value) {
        return preg_replace("/\D+/", "", trim($value));
    }

}

?>
