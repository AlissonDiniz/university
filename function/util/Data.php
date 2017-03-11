<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Data
 *
 * @author Alisson
 */
class Data {

    public function dataBrasilToDataUSA($data) {
        $array = explode("/", $data);
        return $array[2] . "-" . $array[1] . "-" . $array[0];
    }

    public function dataUSAToDataHoraBrasil($data) {
        if ($data == "") {
            return "--/--/----";
        } else {
            return date("d/m/Y H:i", strtotime($data));
        }
    }

    function dataUSAToDataBrasil($data) {
        if ($data == "") {
            return "--/--/----";
        } else {
            return date("d/m/Y", strtotime($data));
        }
    }

    public function formatDataBrasilToDataUsa($data) {
        if ($data == "") {
            return date("Y-m-d");
        } else {
            return date("Y-m-d", strtotime($this->dataBrasilToDataUSA($data)));
        }
    }

    public function formatDataArquivoToBrasil($data) {
        if ($data == "") {
            return "01/01/1970";
        } else {
            return substr($data, 0, 2) . "/" . substr($data, 2, 2) . "/" . substr($data, 4, 4);
        }
    }

    public function formatDataArquivoToUSA($data) {
        if ($data == "") {
            return "1970-01-01";
        } else {
            return substr($data, 4, 4) . "-" . substr($data, 2, 2) . "-" . substr($data, 0, 2);
        }
    }

}

?>
