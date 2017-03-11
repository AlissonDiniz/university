<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MatriculaTurmaDisciplina
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class MatriculaTurmaDisciplina {

    public $id;

    public function listar($matricula) {
        $conection = new Conection();
        $query = "SELECT mtd.*, a.matricula, pe.cpf, pe.nome AS pessoa, d.id AS idDisciplina, d.codigo AS codDisciplina, d.nome AS disciplina, p.codigo AS periodo FROM matricula_turma_disciplina mtd
                    INNER JOIN matricula m ON mtd.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa pe ON pe.id = a.pessoa_id
                    INNER JOIN turma_disciplina td ON td.id = mtd.turma_disciplina_id
                    INNER JOIN turma t ON td.turma_id = t.id
                    INNER JOIN periodo p ON p.id = t.periodo_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    WHERE m.id = '$matricula' AND mtd.situacao <> 'DI'
                    ORDER BY mtd.data LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarByAluno($aluno) {
        $conection = new Conection();
        $query = "SELECT mtd.id, d.codigo, d.nome FROM matricula_turma_disciplina mtd
                    INNER JOIN matricula m ON mtd.matricula_id = m.id
                    INNER JOIN turma_disciplina td ON td.id = mtd.turma_disciplina_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    WHERE m.aluno_id = '$aluno' AND mtd.situacao IN ('DI', 'AP')";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }
    
    public function listarByAlunoAndPeriodo($aluno, $periodo) {
        $conection = new Conection();
        $query = "SELECT mtd.id, d.codigo, d.nome FROM matricula_turma_disciplina mtd
                    INNER JOIN matricula m ON mtd.matricula_id = m.id
                    INNER JOIN turma_disciplina td ON td.id = mtd.turma_disciplina_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    WHERE m.aluno_id = '$aluno' AND m.periodo_id = '$periodo'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarDispensas($matricula) {
        $conection = new Conection();
        $query = "SELECT mtd.*, a.matricula, pe.cpf, pe.nome AS pessoa, d.id AS idDisciplina, d.codigo AS codDisciplina, d.nome AS disciplina, p.codigo AS periodo FROM matricula_turma_disciplina mtd
                    INNER JOIN matricula m ON mtd.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa pe ON pe.id = a.pessoa_id
                    INNER JOIN turma_disciplina td ON td.id = mtd.turma_disciplina_id
                    INNER JOIN turma t ON td.turma_id = t.id
                    INNER JOIN periodo p ON p.id = t.periodo_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    WHERE m.id = '$matricula' AND mtd.situacao = 'DI'
                    ORDER BY mtd.data LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarToTurmaDisciplina($turmaDisciplina) {
        $conection = new Conection();
        $query = "SELECT mtd.*, a.matricula, pe.cpf, pe.nome AS pessoa, d.id AS idDisciplina, d.codigo AS codDisciplina, d.nome AS disciplina, p.codigo AS periodo FROM matricula_turma_disciplina mtd
                    INNER JOIN matricula m ON mtd.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa pe ON pe.id = a.pessoa_id
                    INNER JOIN turma_disciplina td ON td.id = mtd.turma_disciplina_id
                    INNER JOIN turma t ON td.turma_id = t.id
                    INNER JOIN periodo p ON p.id = t.periodo_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    WHERE td.id = '$turmaDisciplina' AND mtd.situacao <> 'DI'
                    ORDER BY mtd.data LIMIT 100";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT mtd.*, a.matricula, pe.nome AS pessoa, d.id AS idDisciplina, d.codigo AS codDisciplina, d.nome AS disciplina, p.codigo AS periodo FROM matricula_turma_disciplina mtd
                    INNER JOIN matricula m ON mtd.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa pe ON pe.id = a.pessoa_id
                    INNER JOIN turma_disciplina td ON td.id = mtd.turma_disciplina_id
                    INNER JOIN turma t ON td.turma_id = t.id
                    INNER JOIN periodo p ON p.id = t.periodo_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    WHERE mtd.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function verificaDisciplina($aluno, $disciplina) {
        $conection = new Conection();
        $query = "SELECT mtd.id FROM matricula_turma_disciplina mtd
                    INNER JOIN matricula m ON m.id = mtd.matricula_id
                    INNER JOIN turma_disciplina td ON td.id = mtd.turma_disciplina_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    WHERE m.aluno_id = '$aluno' AND d.id = '$disciplina' AND mtd.situacao IN ('AP', 'DI', 'EC')";
        $result = $conection->selectQuery($query);
        if ($conection->rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function save($params) {
        $conection = new Conection();
        $matricula = $params['matricula'];
        $turmaDisciplina = $params['idTurmaDisciplina'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO matricula_turma_disciplina
                    (matricula_id, turma_disciplina_id, situacao, status, data, user_create)
                  VALUES
                  ('$matricula', '$turmaDisciplina', 'EC', 1, NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM matricula_turma_disciplina WHERE matricula_id = '$matricula' AND turma_disciplina_id = '$turmaDisciplina' AND situacao = 'EC' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function saveD($params) {
        $conection = new Conection();
        $matricula = $params['matricula'];
        $turmaDisciplina = $params['idTurmaDisciplina'];
        empty($params['resultadoFinal']) ? $resultadoFinal = "NULL" : $resultadoFinal = "'" . $params['resultadoFinal'] . "'";
        empty($params['cargaHorariaDispensada']) ? $cargaHorariaDispensada = "NULL" : $cargaHorariaDispensada = "'" . $params['cargaHorariaDispensada'] . "'";
        $conceito = $params['conceito'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO matricula_turma_disciplina
                    (matricula_id, turma_disciplina_id, resultado_final, conceito, carga_horaria_dispensa, situacao, status, data, user_create)
                  VALUES
                  ('$matricula', '$turmaDisciplina', $resultadoFinal, '$conceito', $cargaHorariaDispensada, 'DI', 1, NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM matricula_turma_disciplina WHERE matricula_id = '$matricula' AND turma_disciplina_id = '$turmaDisciplina' AND situacao = 'DD' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        empty($params['resultado']) ? $resultado = "NULL" : $resultado = "'" . $params['resultado'] . "'";
        empty($params['resultadoFinal']) ? $resultadoFinal = "NULL" : $resultadoFinal = "'" . $params['resultadoFinal'] . "'";
        $situacao = $params['situacao'];
        $status = $params['status'];
        $query = "UPDATE matricula_turma_disciplina 
                    SET resultado = $resultado, 
                        resultado_final = $resultadoFinal, 
                        situacao = '$situacao', 
                        status = $status
                  WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $this->id = $id;
        return true;
    }

    public function updateSituacao($params) {
        $conection = new Conection();
        $id = $params['id'];
        $situacao = $params['situacao'];
        $query = "UPDATE matricula_turma_disciplina 
                    SET situacao = '$situacao' 
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
        $queryNota = "DELETE FROM nota WHERE matricula_turma_disciplina_id = '$id'";
        $queryFalta = "DELETE FROM falta WHERE matricula_turma_disciplina_id = '$id'";
        $query = "DELETE FROM matricula_turma_disciplina WHERE id = '$id'";
        if (!$conection->executeUpdate($queryNota)) {
            return false;
        } else {
            if (!$conection->executeUpdate($queryFalta)) {
                return false;
            } else {
                if (!$conection->executeUpdate($query)) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }

}

?>
