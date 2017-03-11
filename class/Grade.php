<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grade
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Grade {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM grade";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar() {
        $conection = new Conection();
        $query = "SELECT g.*, g.codigo, c.nome FROM grade g
                    INNER JOIN curso c ON c.id = g.curso_id
                    ORDER BY g.data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "SELECT g.*, g.codigo, c.nome FROM grade g
                    INNER JOIN curso c ON c.id = g.curso_id
                    ORDER BY g.data DESC LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarGradesAtivas() {
        $conection = new Conection();
        $query = "SELECT g.id, g.codigo, c.nome FROM grade g
                    INNER JOIN curso c ON c.id = g.curso_id
                    WHERE g.status = 1 AND g.termino > NOW()
                    ORDER BY g.codigo";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT g.*, c.nome FROM grade g
                    INNER JOIN curso c ON c.id = g.curso_id
                    WHERE g.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function save($params) {
        $conection = new Conection();
        $curso = $params['curso'];
        $codigo = $params['codigo'];
        $cargaHoraria = $params['cargaHoraria'];
        $inicio = $params['inicio'];
        $termino = $params['termino'];
        $status = $params['status'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO grade 
                    (curso_id, codigo, carga_horaria, inicio, termino, status, data, user_create)
                  VALUES
                  ('$curso', '$codigo', '$cargaHoraria', '$inicio', '$termino', $status, NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM grade WHERE codigo = '$codigo' AND curso_id = '$curso' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $codigo = $params['codigo'];
        $cargaHoraria = $params['cargaHoraria'];
        $inicio = $params['inicio'];
        $termino = $params['termino'];
        $status = $params['status'];
        $query = "UPDATE grade 
                    SET codigo = '$codigo', 
                        carga_horaria = '$cargaHoraria', 
                        inicio = '$inicio', 
                        termino = '$termino', 
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
        $query = "DELETE FROM grade WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
