<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Parametro
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Parametro {

    public $id;

    public function get() {
        $conection = new Conection();
        $query = "SELECT pa.*, p.codigo AS periodoAtual, p2.codigo AS periodoMatricula FROM parametros pa
                    INNER JOIN periodo p ON p.id = pa.periodo_atual_id
                    INNER JOIN periodo p2 ON p2.id = pa.periodo_matricula_id
                    LIMIT 1";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function update($params) {
        $conection = new Conection();
        $periodoAtual = $params['periodoAtual'];
        $periodoMatricula = $params['periodoMatricula'];
        $taxaBoleto = $params['taxaBoleto'];
        $diasAtrazo = $params['diasAtrazo'];
        $taxaMulta = $params['taxaMulta'];
        $taxaMora = $params['taxaMora'];
        $mensagens = $params['mensagens'];
        $parametro = $this->get();
        if ($parametro['dados']['id'] != "") {
            $query = "UPDATE parametros 
                    SET periodo_atual_id = '$periodoAtual', 
                        periodo_matricula_id = '$periodoMatricula',
                        taxa_boleto = '$taxaBoleto',
                        taxa_multa = '$taxaMulta',
                        taxa_mora = '$taxaMora',
                        mensagens = '$mensagens',
                        dias_para_atrazo = '$diasAtrazo'";
        } else {
            $query = "INSERT INTO parametros (periodo_atual_id, periodo_matricula_id, inadimplencia, taxa_boleto, dias_para_atrazo, taxa_multa, taxa_mora, mensagens)
                            VALUES('$periodoAtual', '$periodoMatricula', NOW(), '$taxaBoleto', '$diasAtrazo', '$taxaMulta', '$taxaMora', '$mensagens')";
        }
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
