<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Report
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Report {

    public $id;

    public function listar() {
        $conection = new Conection();
        $query = "SELECT * FROM report ORDER BY data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT * FROM report WHERE id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function save($params) {
        $conection = new Conection();
        $name = $params['nome'];
        $titulo = $params['titulo'];
        $status = $params['status'];
        $value = $params['value'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO report 
                    (name, titulo, status, value, data, user_create)
                  VALUES
                  ('$name', '$titulo', $status, '$value', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM report WHERE name = '$name' AND titulo = '$titulo' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $name = $params['nome'];
        $titulo = $params['titulo'];
        $status = $params['status'];
        $value = $params['value'];
        $query = "UPDATE report 
                    SET name = '$name', 
                        titulo = '$titulo', 
                        value = '$value', 
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
        $query = "DELETE FROM report WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
