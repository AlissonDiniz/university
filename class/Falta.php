<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Falta
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Falta {

    public $id;

    public function listar($matriculaTurmaDisciplina) {
        $conection = new Conection();
        $query = "SELECT a.matricula, p.nome, p.cpf, f.*, h.dia, h.aulas, au.data_aula FROM falta f
                    INNER JOIN aula au ON au.id = f.aula_id
                    INNER JOIN matricula_turma_disciplina mtd ON mtd.id = f.matricula_turma_disciplina_id
                    INNER JOIN matricula m ON m.id = mtd.matricula_id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    INNER JOIN horario h ON h.id = au.horario_id
                    WHERE f.matricula_turma_disciplina_id = '$matriculaTurmaDisciplina'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarToAula($aula) {
        $conection = new Conection();
        $query = "SELECT a.matricula, p.nome, p.cpf, f.*, h.dia, h.aulas, au.data_aula FROM falta f
                    INNER JOIN aula au ON au.id = f.aula_id
                    INNER JOIN matricula_turma_disciplina mtd ON mtd.id = f.matricula_turma_disciplina_id
                    INNER JOIN matricula m ON m.id = mtd.matricula_id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    INNER JOIN horario h ON h.id = au.horario_id
                    WHERE f.aula_id = '$aula'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT a.matricula, p.nome, p.cpf, f.*, h.dia, h.aulas, au.data_aula FROM falta f
                    INNER JOIN aula au ON au.id = f.aula_id
                    INNER JOIN matricula_turma_disciplina mtd ON mtd.id = f.matricula_turma_disciplina_id
                    INNER JOIN matricula m ON m.id = mtd.matricula_id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    INNER JOIN horario h ON h.id = au.horario_id
                    WHERE f.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function save($matriculaTurmaDisciplina, $aula, $tipo, $valor, $userCreate) {
        $conection = new Conection();
        $query = "INSERT INTO falta 
                    (matricula_turma_disciplina_id, aula_id, tipo, valor, data, user_create)
                  VALUES
                  ('$matriculaTurmaDisciplina', '$aula', '$tipo', '$valor', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

    public function update($id, $tipo, $valor) {
        $conection = new Conection();
        $query = "UPDATE falta
                    SET tipo = '$tipo',
                        valor = '$valor'
                  WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>