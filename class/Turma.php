<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Turma
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Turma {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM turma";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar() {
        $conection = new Conection();
        $query = "SELECT t.*, p.codigo AS periodo, g.codigo AS codGrade, c.nome AS nomeCurso FROM turma t
                    INNER JOIN grade g ON g.id = t.grade_id
                    INNER JOIN curso c ON c.id = g.curso_id
                    INNER JOIN periodo p ON p.id = t.periodo_id
                    ORDER BY t.data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "SELECT t.*, p.codigo AS periodo, g.codigo AS codGrade, c.nome AS nomeCurso FROM turma t
                    INNER JOIN grade g ON g.id = t.grade_id
                    INNER JOIN curso c ON c.id = g.curso_id
                    INNER JOIN periodo p ON p.id = t.periodo_id
                    ORDER BY t.data DESC LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT t.*, p.codigo AS periodo, g.codigo AS codGrade, c.nome AS nomeCurso FROM turma t
                    INNER JOIN grade g ON g.id = t.grade_id
                    INNER JOIN curso c ON c.id = g.curso_id
                    INNER JOIN periodo p ON p.id = t.periodo_id
                    WHERE t.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function getToCodigo($id, $periodo) {
        $conection = new Conection();
        $query = "SELECT t.*, p.codigo AS periodo, g.codigo AS codGrade, c.nome AS nomeCurso FROM turma t
                    INNER JOIN grade g ON g.id = t.grade_id
                    INNER JOIN curso c ON c.id = g.curso_id
                    INNER JOIN periodo p ON p.id = t.periodo_id
                    WHERE t.codigo = '$id' AND t.periodo_id = '$periodo'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function getToAluno($id, $periodo) {
        $conection = new Conection();
        $query = "SELECT t.* FROM turma t
                    INNER JOIN grade g ON g.id = t.grade_id
                    INNER JOIN periodo p ON p.id = t.periodo_id
                    INNER JOIN aluno a ON a.grade_id = g.id AND a.modulo = SUBSTRING(t.codigo, 6, 2) AND a.turno = SUBSTRING(t.codigo, 10, 1)
                    WHERE a.id = '$id' AND t.periodo_id = '$periodo'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();

        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("id" => $array['id'], "codigo" => $array['codigo']);
        }
        return $arrayRetorno;
    }
    
    public function getTurmasTransferir($idAluno, $periodo) {
        $conection = new Conection();
        $query = "SELECT t.* FROM aluno a
                    INNER JOIN matricula m ON m.aluno_id = a.id
                    INNER JOIN turma t ON m.turma_id <> t.id AND m.periodo_id = '$periodo' AND m.periodo_id = t.periodo_id AND t.grade_id = a.grade_id AND t.codigo LIKE CONCAT('_____', a.modulo, '___')
                    WHERE m.aluno_id = '$idAluno'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("id" => $array['id'], "codigo" => $array['codigo']);
        }
        return $arrayRetorno;
    }

    public function getToGrade($id, $periodo) {
        $conection = new Conection();
        $query = "SELECT t.* FROM turma t
                    INNER JOIN grade g ON g.id = t.grade_id
                    INNER JOIN periodo p ON p.id = t.periodo_id
                    WHERE g.id = '$id' AND t.periodo_id = '$periodo'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();

        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("id" => $array['id'], "codigo" => $array['codigo']);
        }
        return $arrayRetorno;
    }

    public function save($params) {
        $conection = new Conection();
        $codigo = $params['codigo'];
        $grade = $params['grade'];
        $periodo = $params['periodo'];
        $observacao = $params['observacao'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO turma 
                    (codigo, grade_id, periodo_id, observacao, data, user_create)
                  VALUES
                  ('$codigo', '$grade', '$periodo', '$observacao', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM turma WHERE codigo = '$codigo' AND grade_id = '$grade' AND periodo_id = '$periodo' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $observacao = $params['observacao'];
        $query = "UPDATE turma 
                    SET observacao = '$observacao'
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
        $query = "DELETE FROM turma WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
