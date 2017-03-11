<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Horario
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Horario {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM horario";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar($turmaDisciplina) {
        $conection = new Conection();
        $query = "SELECT h.*, td.horario AS tipoHorario, s.codigo AS sala, pe.nome AS professor FROM horario h
                    INNER JOIN sala s ON s.id = h.sala_id
                    INNER JOIN turma_disciplina td ON h.turma_disciplina_id = td.id
                    INNER JOIN turma t ON t.id = td.turma_id
                    INNER JOIN professor p ON p.id = h.professor_id
                    INNER JOIN pessoa pe ON pe.id = p.pessoa_id
                    WHERE h.turma_disciplina_id LIKE '$turmaDisciplina'
                    ORDER BY h.data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "SELECT h.*, td.horario AS tipoHorario, s.codigo AS sala, pe.nome AS professor FROM horario h
                    INNER JOIN sala s ON s.id = h.sala_id
                    INNER JOIN turma_disciplina td ON h.turma_disciplina_id = td.id
                    INNER JOIN turma t ON t.id = td.turma_id
                    INNER JOIN professor p ON p.id = h.professor_id
                    INNER JOIN pessoa pe ON pe.id = p.pessoa_id
                    ORDER BY h.data DESC LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT h.*, td.horario AS tipoHorario, s.codigo AS sala, pe.nome AS professor FROM horario h
                    INNER JOIN sala s ON s.id = h.sala_id
                    INNER JOIN turma_disciplina td ON h.turma_disciplina_id = td.id
                    INNER JOIN turma t ON t.id = td.turma_id
                    INNER JOIN professor p ON p.id = h.professor_id
                    INNER JOIN pessoa pe ON pe.id = p.pessoa_id
                    WHERE h.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function getToSala($id, $dia) {
        $conection = new Conection();
        $query = "SELECT h.*, td.horario AS tipoHorario, s.codigo AS sala, pe.nome AS professor FROM horario h
                    INNER JOIN sala s ON s.id = h.sala_id
                    INNER JOIN turma_disciplina td ON h.turma_disciplina_id = td.id
                    INNER JOIN turma t ON t.id = td.turma_id
                    INNER JOIN professor p ON p.id = h.professor_id
                    INNER JOIN pessoa pe ON pe.id = p.pessoa_id
                    WHERE h.sala_id = '$id' AND h.dia = '$dia'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function getToProfessor($id, $dia) {
        $conection = new Conection();
        $query = "SELECT h.*, td.horario AS tipoHorario, s.codigo AS sala, pe.nome AS professor FROM horario h
                    INNER JOIN sala s ON s.id = h.sala_id
                    INNER JOIN turma_disciplina td ON h.turma_disciplina_id = td.id
                    INNER JOIN turma t ON t.id = td.turma_id
                    INNER JOIN professor p ON p.id = h.professor_id
                    INNER JOIN pessoa pe ON pe.id = p.pessoa_id
                    WHERE h.professor_id = '$id' AND h.dia = '$dia'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function save($params) {
        $conection = new Conection();
        $professor = $params['professor'];
        $turmaDisciplina = $params['td'];
        $sala = $params['sala'];
        $turno = $params['turno'];
        $inicio = $params['inicio'];
        $termino = $params['termino'];
        $aulas = $params['aulas'];
        $dia = $params['dia'];
        $observacao = $params['observacao'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO horario 
                    (professor_id, turma_disciplina_id, sala_id, inicio, termino, turno, aulas, dia, observacao, data, user_create)
                  VALUES
                  ('$professor', '$turmaDisciplina', '$sala', '$inicio', '$termino', '$turno', '$aulas', '$dia', '$observacao', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM horario WHERE professor_id = '$professor' AND turma_disciplina_id = '$turmaDisciplina' AND sala_id = '$sala' AND dia = '$dia' AND inicio = '$inicio' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $sala = $params['sala'];
        $inicio = $params['inicio'];
        $termino = $params['termino'];
        $dia = $params['dia'];
        $observacao = $params['observacao'];
        $query = "UPDATE horario 
                    SET sala_id = '$sala', 
                        inicio = '$inicio', 
                        termino = '$termino',
                        dia = '$dia',
                        observacao = '$observacao' 
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
        $query = "DELETE FROM horario WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
