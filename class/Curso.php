<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Curso
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Curso {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM curso";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar($status) {
        $conection = new Conection();
        $query = "SELECT * FROM curso WHERE status LIKE '$status' ORDER BY nome LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "SELECT * FROM curso ORDER BY nome LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT * FROM curso WHERE id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function save($params) {
        $conection = new Conection();
        $codigo = $params['codigo'];
        $nome = $params['nome'];
        $observacao = $params['observacao'];
        $status = $params['status'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO curso 
                    (codigo, nome, observacao, status, data, user_create)
                  VALUES
                  ('$codigo', '$nome', '$observacao', $status, NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM curso WHERE codigo = '$codigo' AND nome = '$nome' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $codigo = $params['codigo'];
        $nome = $params['nome'];
        $observacao = $params['observacao'];
        $status = $params['status'];
        $query = "UPDATE curso 
                    SET codigo = '$codigo', 
                        nome = '$nome', 
                        observacao = '$observacao', 
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
        $query = "DELETE FROM curso WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
