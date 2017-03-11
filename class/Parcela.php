<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Parcela
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Parcela {

    public $id;

    public function listar($plano) {
        $conection = new Conection();
        $query = "SELECT p.*, pa.configuracao_id AS configuracao FROM parcela p
                    INNER JOIN plano pa ON p.plano_id = pa.id AND pa.id = '$plano'
                    ORDER BY p.numero, p.data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT p.*, pa.configuracao_id AS configuracao, pe.codigo AS periodo, c.nome AS curso, pa.descricao FROM parcela p
                    INNER JOIN plano pa ON pa.id = p.plano_id
                    INNER JOIN periodo pe ON pe.id = pa.periodo_id
                    INNER JOIN curso c ON c.id = pa.curso_id
                    WHERE p.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }
    
    public function getByMatriucula($idMatricula) {
        $conection = new Conection();
        $query = "SELECT p.* FROM parcela p
                    INNER JOIN plano pa ON pa.id = p.plano_id
                    INNER JOIN matricula m ON m.plano_id = p.id
                    WHERE m.id = '$idMatricula'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function save($params) {
        $conection = new Conection();
        $plano = $params['plano'];
        $valor = $params['valor'];
        $vencimento = $params['vencimento'];
        $mes = $params['mes'];
        $parcela = $params['parcela'];
        $observacao = $params['observacao'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO parcela 
                    (plano_id, mes, numero, valor, data_vencimento, observacao, data, user_create)
                  VALUES
                  ('$plano', '$mes', '$parcela', '$valor', '$vencimento', '$observacao', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM parcela WHERE plano_id = '$plano' AND mes = '$mes' AND numero = '$parcela' AND valor = '$valor' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $valor = $params['valor'];
        $vencimento = $params['vencimento'];
        $mes = $params['mes'];
        $parcela = $params['parcela'];
        $observacao = $params['observacao'];
        $query = "UPDATE parcela 
                    SET observacao = '$observacao',
                        data_vencimento = '$vencimento',
                        numero = '$parcela',
                        valor = '$valor',
                        mes = '$mes'
                  WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $this->id = $id;
        return true;
    }

    public function delete($params) {
        $conection = new Conection();
        $id = $params['id'];
        $query = "DELETE FROM parcela WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
