<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EquivalenciaDisciplina
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class EquivalenciaDisciplina {

    public $id;

    public function listar($aluno) {
        $conection = new Conection();
        $query = "SELECT eq.*, p.codigo AS periodo, d.nome AS disciplina, d.codigo AS codigoDisciplina, d2.nome AS disciplinaEQ, d2.codigo AS codigoDisciplinaEQ, mtd.situacao FROM equivalencia_disciplina eq
                    INNER JOIN matricula_turma_disciplina mtd ON mtd.id = eq.matricula_turma_disciplina_id
                    INNER JOIN turma_disciplina td ON td.id = mtd.turma_disciplina_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    INNER JOIN matricula m ON m.id = mtd.matricula_id
                    INNER JOIN periodo p ON p.id = m.periodo_id
                    INNER JOIN disciplina d2 ON d2.id = eq.disciplina_equivalente_id
                    WHERE m.aluno_id = '$aluno'
                    ORDER BY eq.data LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT eq.*, a.id AS aluno, p.codigo AS periodo, d.nome AS disciplina, d.codigo AS codigoDisciplina, d2.nome AS disciplinaEQ, d2.codigo AS codigoDisciplinaEQ, mtd.situacao FROM equivalencia_disciplina eq
                    INNER JOIN matricula_turma_disciplina mtd ON mtd.id = eq.matricula_turma_disciplina_id
                    INNER JOIN turma_disciplina td ON td.id = mtd.turma_disciplina_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    INNER JOIN matricula m ON m.id = mtd.matricula_id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN periodo p ON p.id = m.periodo_id
                    INNER JOIN disciplina d2 ON d2.id = eq.disciplina_equivalente_id
                    WHERE eq.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function save($params) {
        $conection = new Conection();
        $disciplinaEquivalente = $params['disciplinaEquivalente'];
        $matriculaTurmaDisciplina = $params['matriculaTurmaDisciplina'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO equivalencia_disciplina
                    (matricula_turma_disciplina_id, disciplina_equivalente_id, status, data, user_create)
                  VALUES
                  ('$matriculaTurmaDisciplina', '$disciplinaEquivalente', 1, NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM equivalencia_disciplina WHERE matricula_turma_disciplina_id = '$matriculaTurmaDisciplina' AND disciplina_equivalente_id = '$disciplinaEquivalente' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function delete($params) {
        $conection = new Conection();
        $id = $params['id'];
        $query = "DELETE FROM equivalencia_disciplina WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {return false;}
        return true;
    }

}
?>
