<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Disciplina
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Disciplina {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM disciplina";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar() {
        $conection = new Conection();
        $query = "SELECT * FROM disciplina ORDER BY nome LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "SELECT * FROM disciplina ORDER BY nome LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarByGrade($grade) {
        $conection = new Conection();
        $query = "SELECT d.* FROM disciplina d
                    INNER JOIN modulo_disciplina md ON md.disciplina_id = d.id
                    INNER JOIN modulo m ON m.id = md.modulo_id
                    WHERE m.grade_id = '$grade'
                    ORDER BY nome LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT * FROM disciplina WHERE id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function save($params) {
        $conection = new Conection();
        $cargaHoraria = $params['cargaHoraria'];
        $codigo = $params['codigo'];
        $nome = $params['nome'];
        $observacao = $params['observacao'];
        $status = $params['status'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO disciplina 
                    (carga_horaria, codigo, nome, observacao, status, data, user_create)
                  VALUES
                  ('$cargaHoraria', '$codigo', '$nome', '$observacao', $status, NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM disciplina WHERE codigo = '$codigo' AND nome = '$nome' AND carga_horaria = '$cargaHoraria' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $cargaHoraria = $params['cargaHoraria'];
        $codigo = $params['codigo'];
        $nome = $params['nome'];
        $observacao = $params['observacao'];
        $status = $params['status'];
        $query = "UPDATE disciplina 
                    SET carga_horaria = '$cargaHoraria', 
                        codigo = '$codigo', 
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
        $query = "DELETE FROM disciplina WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
