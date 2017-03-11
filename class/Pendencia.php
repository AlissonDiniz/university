<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pendencia
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Pendencia {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM pendencia";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar() {
        $conection = new Conection();
        $query = "SELECT pe.*, p.nome, p.cpf FROM pendencia pe
                    INNER JOIN pessoa p on pe.pessoa_id = p.id
                    ORDER BY pe.data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "SELECT pe.*, p.nome, p.cpf FROM pendencia pe
                    INNER JOIN pessoa p on pe.pessoa_id = p.id
                    ORDER BY pe.data DESC LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT pe.*, p.nome, p.cpf FROM pendencia pe
                    INNER JOIN pessoa p on pe.pessoa_id = p.id 
                    WHERE pe.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function getToPessoaBloqueia($pessoa) {
        $conection = new Conection();
        $query = "SELECT pe.id FROM pendencia pe
                    INNER JOIN pessoa p on pe.pessoa_id = p.id
                    WHERE p.id = '$pessoa' AND pe.type = '1'
                    ORDER BY pe.data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        if ($conection->rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getToPessoa($pessoa) {
        $conection = new Conection();
        $query = "SELECT pe.*, p.nome, p.cpf FROM pendencia pe
                    INNER JOIN pessoa p on pe.pessoa_id = p.id
                    WHERE p.id = '$pessoa'
                    ORDER BY pe.data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function save($params) {
        $conection = new Conection();
        $pessoa = $params['pessoa'];
        $descricao = $params['descricao'];
        $origem = $params['origem'];
        $type = $params['type'];
        $status = $params['status'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO pendencia 
                    (pessoa_id, descricao, origem, type, status, data, user_create)
                  VALUES
                  ('$pessoa', '$descricao', '$origem', '$type', $status, NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM pendencia WHERE pessoa_id = '$pessoa' AND descricao = '$descricao' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $descricao = $params['descricao'];
        $origem = $params['origem'];
        $type = $params['type'];
        $status = $params['status'];
        $query = "UPDATE pendencia 
                    SET descricao = '$descricao', 
                        origem = '$origem', 
                        type = '$type', 
                        status = $status
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
        $query = "DELETE FROM pendencia WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>