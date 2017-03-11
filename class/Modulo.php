<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modulo
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Modulo {

    public $id;

    public function listar($grade) {
        $conection = new Conection();
        $query = "SELECT m.*, g.codigo AS codGrade FROM modulo m
                    INNER JOIN grade g ON m.grade_id = g.id
                    WHERE m.grade_id = '$grade' ORDER BY m.descricao LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }
    
    public function listarDisciplinasDoModulo($turma, $grade, $codigo) {
        $conection = new Conection();
        $query = "SELECT d.id, d.codigo, d.nome, td.turma_id FROM modulo m
                    INNER JOIN modulo_disciplina md ON md.modulo_id = m.id
                    INNER JOIN disciplina d ON md.disciplina_id = d.id
                    LEFT JOIN turma_disciplina td ON td.disciplina_id = d.id AND td.turma_id = '$turma'
                    WHERE td.turma_id IS NULL AND m.codigo = '$codigo' AND m.grade_id = '$grade' AND d.status = '1'
                  GROUP BY d.id, d.codigo, d.nome
                  ORDER BY d.nome LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT m.*, g.codigo AS codGrade FROM modulo m
                    INNER JOIN grade g ON m.grade_id = g.id
                    WHERE m.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function save($params) {
        $conection = new Conection();
        $grade = $params['grade'];
        $codigo = $params['codigo'];
        $descricao = $params['descricao'];
        $cargaHoraria = $params['cargaHoraria'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO modulo 
                    (grade_id, codigo, descricao, carga_horaria, data, user_create)
                  VALUES
                  ('$grade', '$codigo', '$descricao', '$cargaHoraria', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM modulo WHERE codigo = '$codigo' AND descricao = '$descricao' AND grade_id = '$grade' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $descricao = $params['descricao'];
        $cargaHoraria = $params['cargaHoraria'];
        $query = "UPDATE modulo 
                    SET descricao = '$descricao', 
                        carga_horaria = '$cargaHoraria'
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
        $query = "DELETE FROM modulo WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
