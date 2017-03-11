<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mensagem
 *
 * @author Alisson
 */
require_once '../../config/Conection.php';

class Mensagem {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM mensagem WHERE type = 'ALUNO'";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "SELECT * FROM mensagem WHERE type = 'ALUNO' ORDER BY id LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT * FROM mensagem WHERE id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function updateStatus($params) {
        $conection = new Conection();
        $id = $params['id'];
        $status = $params['status'];
        $query = "UPDATE mensagem 
                    SET status = '$status'
                  WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $this->id = $id;
        return true;
    }

}

?>
