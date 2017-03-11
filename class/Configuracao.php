<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Configuracao
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Configuracao {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM configuracao";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar() {
        $conection = new Conection();
        $query = "SELECT * FROM configuracao ORDER BY banco LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "SELECT * FROM configuracao ORDER BY banco LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT * FROM configuracao WHERE id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function getByTitulo($idTitulo) {
        $conection = new Conection();
        $query = "SELECT c.* FROM configuracao c
                    INNER JOIN titulo t ON t.configuracao_id = c.id
                    WHERE t.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function save($params) {
        $conection = new Conection();
        $banco = $params['banco'];
        $nomeBanco = $params['nomeBanco'];
        $agencia = $params['agencia'];
        $conta = $params['conta'];
        $codigoCliente = $params['codigoCliente'];
        $codigoRemessa = $params['codigoRemessa'];
        $carteira = $params['carteira'];
        $convenio = $params['convenio'];
        $operacao = $params['operacao'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO configuracao 
                    (banco, nome_banco, agencia, conta, codigo_cliente, codigo_remessa, carteira, convenio, operacao, data, user_create)
                  VALUES
                  ('$banco', '$nomeBanco', '$agencia', '$conta', '$codigoCliente', '$codigoRemessa', '$carteira', '$convenio', '$operacao', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM configuracao WHERE banco = '$banco' AND agencia = '$agencia' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $banco = $params['banco'];
        $nomeBanco = $params['nomeBanco'];
        $agencia = $params['agencia'];
        $conta = $params['conta'];
        $codigoCliente = $params['codigoCliente'];
        $codigoRemessa = $params['codigoRemessa'];
        $carteira = $params['carteira'];
        $convenio = $params['convenio'];
        $operacao = $params['operacao'];
        $query = "UPDATE configuracao 
                    SET banco = '$banco', 
                        nome_banco = '$nomeBanco', 
                        agencia = '$agencia', 
                        conta = '$conta', 
                        codigo_cliente = '$codigoCliente', 
                        codigo_remessa = '$codigoRemessa', 
                        carteira = '$carteira', 
                        convenio = '$convenio', 
                        operacao = '$operacao'
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
        $query = "DELETE FROM configuracao WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
