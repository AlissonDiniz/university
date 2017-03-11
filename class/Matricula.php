<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Matricula
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Matricula {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM matricula";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar() {
        $conection = new Conection();
        $query = "SELECT m.*, a.matricula, pe.nome, pe2.id AS idResponsavel, pe2.cpf AS cpfResponsavel, pe2.nome AS responsavel, p.codigo AS periodo, t.id AS idTurma, t.codigo AS turma, pl.descricao AS plano FROM matricula m
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa pe ON pe.id = a.pessoa_id
                    INNER JOIN pessoa pe2 ON pe2.id = m.responsavel_id
                    INNER JOIN periodo p ON p.id = m.periodo_id
                    INNER JOIN turma t ON m.turma_id = t.id
                    LEFT JOIN plano pl ON pl.id = m.plano_id
                    ORDER BY m.data LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "SELECT m.*, a.matricula, pe.nome, pe2.id AS idResponsavel, pe2.cpf AS cpfResponsavel, pe2.nome AS responsavel, p.codigo AS periodo, t.id AS idTurma, t.codigo AS turma, pl.descricao AS plano FROM matricula m
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa pe ON pe.id = a.pessoa_id
                    INNER JOIN pessoa pe2 ON pe2.id = m.responsavel_id
                    INNER JOIN periodo p ON p.id = m.periodo_id
                    INNER JOIN turma t ON m.turma_id = t.id
                    LEFT JOIN plano pl ON pl.id = m.plano_id
                    ORDER BY m.data LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarByAluno($aluno) {
        $conection = new Conection();
        $query = "SELECT m.*, a.matricula, pe.nome, pe2.id AS idResponsavel, pe2.cpf AS cpfResponsavel, pe2.nome AS responsavel, p.codigo AS periodo, t.id AS idTurma, t.codigo AS turma, pl.descricao AS plano FROM matricula m
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa pe ON pe.id = a.pessoa_id
                    INNER JOIN pessoa pe2 ON pe2.id = m.responsavel_id
                    INNER JOIN periodo p ON p.id = m.periodo_id
                    INNER JOIN turma t ON m.turma_id = t.id
                    LEFT JOIN plano pl ON pl.id = m.plano_id
                    WHERE a.id = '$aluno'
                    ORDER BY m.data LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarByTurma($idPeriodo, $idTurma) {
        $conection = new Conection();
        $query = "SELECT a.* FROM aluno a
                    INNER JOIN matricula m ON m.aluno_id = a.id
                    WHERE m.periodo_id = '$idPeriodo' AND m.turma_id = '$idTurma'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarByGrade($idPeriodo, $idGrade) {
        $conection = new Conection();
        $query = "SELECT a.* FROM aluno a
                    INNER JOIN matricula m ON m.aluno_id = a.id
                    WHERE m.periodo_id = '$idPeriodo' AND a.grade_id = '$idGrade'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT m.*, a.matricula, pe.nome, pe2.id AS idResponsavel, pe2.cpf AS cpfResponsavel, pe2.nome AS responsavel, p.codigo AS periodo, t.id AS idTurma, t.codigo AS turma, pl.descricao AS plano FROM matricula m
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa pe ON pe.id = a.pessoa_id
                    INNER JOIN pessoa pe2 ON pe2.id = m.responsavel_id
                    INNER JOIN periodo p ON p.id = m.periodo_id
                    INNER JOIN turma t ON m.turma_id = t.id
                    LEFT JOIN plano pl ON pl.id = m.plano_id
                    WHERE m.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function getToAluno($aluno) {
        $conection = new Conection();
        $query = "SELECT m.*, a.matricula, pe.nome, pe2.id AS idResponsavel, pe2.cpf AS cpfResponsavel, pe2.nome AS responsavel, p.codigo AS periodo, t.id AS idTurma, t.codigo AS turma, pl.descricao AS plano FROM matricula m
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa pe ON pe.id = a.pessoa_id
                    INNER JOIN pessoa pe2 ON pe2.id = m.responsavel_id
                    INNER JOIN periodo p ON p.id = m.periodo_id
                    INNER JOIN turma t ON m.turma_id = t.id
                    LEFT JOIN plano pl ON pl.id = m.plano_id
                    WHERE a.id = '$aluno'
                    ORDER BY m.data LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function getToAlunoAndPeriodo($aluno, $periodo) {
        $conection = new Conection();
        $query = "SELECT m.* FROM matricula m
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN periodo p ON p.id = m.periodo_id
                    INNER JOIN turma t ON m.turma_id = t.id
                    WHERE a.id = '$aluno'  AND p.id = '$periodo'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function verificaMatriculaAluno($aluno, $periodo) {
        $conection = new Conection();
        $query = "SELECT * FROM matricula WHERE aluno_id = '$aluno' AND periodo_id = '$periodo'";
        $result = $conection->selectQuery($query);
        if ($conection->rows($result) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function save($params) {
        $conection = new Conection();
        $aluno = $params['aluno'];
        $responsavel = $params['responsavel'];
        empty($params['plano']) ? $plano = "NULL" : $plano = "'" . $params['plano'] . "'";
        $periodo = $params['periodo'];
        $turma = $params['turma'];
        $situacao = $params['situacao'];
        $observacao = $params['observacao'];
        $status = $params['status'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO matricula 
                    (aluno_id, responsavel_id, plano_id, periodo_id, turma_id, situacao, observacao, status, data_situacao, data, user_create)
                  VALUES
                  ('$aluno', '$responsavel', $plano, '$periodo', '$turma', '$situacao', '$observacao', $status, NOW(), NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM matricula WHERE aluno_id = '$aluno' AND responsavel_id = '$responsavel' AND periodo_id = '$periodo' AND turma_id = '$turma' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $responsavel = $params['responsavel'];
        $observacao = $params['observacao'];
        $status = $params['status'];
        $query = "UPDATE matricula 
                    SET responsavel_id = '$responsavel', 
                        observacao = '$observacao', 
                        status = $status
                  WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $this->id = $id;
        return true;
    }
    
    public function updateTurma($id, $turma) {
        $conection = new Conection();
        $query = "UPDATE matricula 
                    SET turma_id = '$turma' 
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
        $query = "DELETE FROM matricula WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

    public function updateSituacao($params) {
        $conection = new Conection();
        $id = $params['id'];
        $situacao = $params['situacao'];
        $query = "UPDATE matricula SET situacao = '$situacao' WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
