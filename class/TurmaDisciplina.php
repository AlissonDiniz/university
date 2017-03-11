<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TurmaDisciplina
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class TurmaDisciplina {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM turma_disciplina";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar($turma) {
        $conection = new Conection();
        $query = "SELECT td.*, t.codigo AS turma, p.codigo AS periodo, d.id AS idDisciplina, d.codigo AS codDisciplina, d.nome AS disciplina FROM turma_disciplina td
                    INNER JOIN turma t ON t.id = td.turma_id
                    INNER JOIN periodo p ON t.periodo_id = p.id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    WHERE t.id LIKE '$turma'
                    ORDER BY td.data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "SELECT td.*, t.codigo AS turma, p.codigo AS periodo, d.id AS idDisciplina, d.codigo AS codDisciplina, d.nome AS disciplina FROM turma_disciplina td
                    INNER JOIN turma t ON t.id = td.turma_id
                    INNER JOIN periodo p ON t.periodo_id = p.id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    ORDER BY td.data DESC LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT td.*, t.codigo AS turma, p.codigo AS periodo, d.id AS idDisciplina, d.codigo AS codDisciplina, d.nome AS disciplina FROM turma_disciplina td
                    INNER JOIN turma t ON t.id = td.turma_id
                    INNER JOIN periodo p ON t.periodo_id = p.id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    WHERE td.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function getToDiario($id, $horario) {
        $conection = new Conection();
        $query = "SELECT td.*, 
            d.id AS idDisciplina, 
            d.codigo AS codDisciplina, 
            d.nome AS disciplina,
            p.nome AS nomeProfessor
            FROM turma_disciplina td
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    LEFT JOIN horario h ON h.turma_disciplina_id = td.id AND h.id = '$horario'
                    LEFT JOIN professor po ON po.id = h.professor_id
                    LEFT JOIN pessoa p ON p.id = po.pessoa_id
                    WHERE td.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function listarByTurma($turma) {
        $conection = new Conection();
        $query = "SELECT d.nome AS nomeDisciplina, d.codigo AS codigoDisciplina, td.* FROM turma_disciplina td
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    WHERE td.turma_id = '$turma'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function getToTurma($aluno, $turma) {
        $conection = new Conection();
        $query = "SELECT td.*, t.codigo AS turma, p.codigo AS periodo, d.id AS idDisciplina, d.codigo AS codDisciplina, d.nome AS disciplina, h.dia, h.inicio, h.termino, s.codigo AS sala FROM turma_disciplina td
                    INNER JOIN turma t ON t.id = td.turma_id
                    INNER JOIN periodo p ON t.periodo_id = p.id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    LEFT JOIN matricula_turma_disciplina mtd ON mtd.turma_disciplina_id = td.id AND mtd.situacao IN ('AP', 'DI', 'EC')
                    LEFT JOIN matricula m ON m.id = mtd.matricula_id AND m.aluno_id = '$aluno'
                    LEFT JOIN horario h ON td.id = h.turma_disciplina_id
                    LEFT JOIN sala s ON s.id = h.sala_id
                    WHERE t.id = '$turma' AND td.status = '1' AND m.id IS NULL
                    ORDER BY td.id, td.data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function save($params) {
        $conection = new Conection();
        $disciplina = $params['disciplina'];
        $turma = $params['turma'];
        $formula = $params['formula'];
        $inicio = $params['inicio'];
        $termino = $params['termino'];
        $horario = $params['horario'];
        $vagas = $params['vagas'];
        $status = $params['status'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO turma_disciplina
                    (disciplina_id, turma_id, inicio, termino, formula, vagas, horario, status, data, user_create)
                  VALUES
                  ('$disciplina', '$turma', '$inicio', '$termino', '$formula', '$vagas', '$horario', $status, NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM turma_disciplina WHERE disciplina_id = '$disciplina' AND turma_id = '$turma' AND inicio = '$inicio' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $formula = $params['formula'];
        $inicio = $params['inicio'];
        $termino = $params['termino'];
        $horario = $params['horario'];
        $vagas = $params['vagas'];
        $status = $params['status'];
        $query = "UPDATE turma_disciplina 
                    SET formula = '$formula',
                        inicio = '$inicio',
                        termino = '$termino',
                        horario = '$horario',
                        vagas = '$vagas',
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
        $query = "DELETE FROM turma_disciplina WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
