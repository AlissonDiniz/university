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
require_once '../../config/Conection.php';

class Professor {

    public $id;

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT pro.*, p.nome, p.cpf FROM professor pro
                    INNER JOIN pessoa p ON pro.pessoa_id = p.id WHERE pro.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function updateSenha($params) {
        $conection = new Conection();
        $id = $params['id'];
        $password = $params['password'];
        $query = "UPDATE professor 
                    SET password = '$password' 
                  WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $this->id = $id;
        return true;
    }

}

?>