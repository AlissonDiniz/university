<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Number
 *
 * @author Alisson
 */
class Number {

    public function formatNumber($value) {
        if ($value != "") {
            return number_format($value, 0, "", "");
        } else {
            return "";
        }
    }

    public function formatNota($value) {
        if ($value != "") {
            return number_format($value, 1, ".", "");
        } else {
            return "";
        }
    }

    public function formatCRE($value) {
        if ($value != "") {
            return number_format($value, 3, ".", "");
        } else {
            return "";
        }
    }

    public function formatCarga($value) {
        if ($value != "") {
            return number_format($value, 0, "", ".");
        } else {
            return "";
        }
    }

    public function formatMoney($value) {
        if ($value != "") {
            return "R$ " . number_format($value, 2, ",", ".");
        } else {
            return "R$ 0.00";
        }
    }

    public function formatCurrency($value) {
        if ($value != "") {
            return number_format(str_replace(",", "", $value), 2, ".", "");
        } else {
            return "0.00";
        }
    }

    public function formatCurrencyArquivo($value) {
        return number_format(substr($value, 0, 13) . "." . substr($value, 13, 2), 2, ".", "");
    }

}

?>
