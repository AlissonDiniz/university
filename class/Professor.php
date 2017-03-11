<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Professor
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Professor {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM professor";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar() {
        $conection = new Conection();
        $query = "SELECT pro.*, p.nome, p.cpf FROM professor pro
                    INNER JOIN pessoa p ON pro.pessoa_id = p.id
                    ORDER BY pro.data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "SELECT pro.*, p.nome, p.cpf FROM professor pro
                    INNER JOIN pessoa p ON pro.pessoa_id = p.id
                    ORDER BY pro.data DESC LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT pro.*, p.nome, p.cpf FROM professor pro
                    INNER JOIN pessoa p ON pro.pessoa_id = p.id WHERE pro.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function createUsername($nome) {
        $arrayNome = explode(" ", $nome);
        return $arrayNome[0] . substr($arrayNome[1], 0, 1) . $arrayNome[count($arrayNome) - 1];
    }

    public function save($params) {
        $conection = new Conection();
        $pessoa = $params['pessoa'];
        $username = $params['username'];
        $password = $params['password'];
        $observacao = $params['observacao'];
        $status = $params['status'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO professor 
                    (pessoa_id, username, password, observacao, status, data, user_create)
                  VALUES
                  ('$pessoa', '$username', '" . sha1($password) . "', '$observacao', '$status', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM professor WHERE pessoa_id = '$pessoa' AND username = '$username' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $username = $params['username'];
        $password = "";
        $observacao = $params['observacao'];
        empty($params['password']) ? null : $password = "password = '" . sha1($params['password']) . "', ";
        $status = $params['status'];
        $query = "UPDATE professor 
                    SET username = '$username',
                        $password
                        observacao = '$observacao', 
                        status = '$status'
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
        $query = "DELETE FROM professor WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>