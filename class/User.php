<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Alisson
 */
class User {

    public $id;

    public function listar() {
        $conection = new Conection();
        $query = "SELECT u.*, r.descricao FROM usuario u 
                    INNER JOIN role r ON r.id = u.role_id
                    ORDER BY u.username";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT u.*, r.descricao FROM usuario u 
                    INNER JOIN role r ON r.id = u.role_id
                    WHERE u.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function getByUsername($username) {
        $conection = new Conection();
        $query = "SELECT u.*, r.descricao FROM usuario u 
                    INNER JOIN role r ON r.id = u.role_id
                    WHERE u.username = '$username'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function save($params) {
        $conection = new Conection();
        $nome = $params['nome'];
        $username = $params['username'];
        $password = sha1($params['password']);
        $enable = $params['status'];
        $role = $params['role'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO usuario 
                    (nome, username, password, enabled, role_id, data, user_create)
                  VALUES
                  ('$nome', '$username', '$password', $enable, '$role', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {return false;}
        $query = "SELECT id FROM usuario WHERE nome = '$nome' AND username = '$username' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $nome = $params['nome'];
        $enable = $params['status'];
        $role = $params['role'];
        $query = "UPDATE usuario 
                    SET nome = '$nome', 
                        role_id = '$role', 
                        enabled = $enable
                  WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {return false;}
        $this->id = $id;
        return true;
    }

    public function updateSenha($params) {
        $conection = new Conection();
        $id = $params['id'];
        $password = sha1($params['password']);
        $query = "UPDATE usuario 
                    SET password = '$password' 
                  WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {return false;}
        $this->id = $id;
        return true;
    }
    
}

?>
