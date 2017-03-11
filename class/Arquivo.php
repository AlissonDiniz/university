<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Arquivo
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Arquivo {

    public $id;

    public function count($type) {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM arquivo WHERE type = '$type'";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar($type) {
        $conection = new Conection();
        $query = "SELECT a.*, u.nome AS usuario FROM arquivo a 
                    INNER JOIN usuario u ON a.user_create = u.username
                    WHERE type = '$type'
                    ORDER BY data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($type, $limit) {
        $conection = new Conection();
        $query = "SELECT a.*, u.nome AS usuario FROM arquivo a 
                    INNER JOIN usuario u ON a.user_create = u.username
                    WHERE type = '$type'
                    ORDER BY data DESC LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT a.*, u.nome AS usuario FROM arquivo a 
                    INNER JOIN usuario u ON a.user_create = u.username 
                    WHERE a.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function save($params) {
        $conection = new Conection();
        $nome = $params['nome'];
        $descricao = $params['descricao'];
        $type = $params['type'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO arquivo 
                    (nome, descricao, type, data, user_create)
                  VALUES
                  ('$nome', '$descricao', '$type', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM arquivo WHERE nome = '$nome' AND descricao = '$descricao' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

}

?>