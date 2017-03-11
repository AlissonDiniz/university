<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Aula
 *
 * @author Alisson
 */
require_once '../../config/Conection.php';

class Aula {

    public $id;

    public function listar($turmaDisciplina) {
        $conection = new Conection();
        $query = "SELECT a.*, td.id AS turmaDisciplina, h.dia, h.inicio, h.termino, h.aulas, s.codigo AS sala FROM aula a
                    INNER JOIN horario h ON a.horario_id = h.id
                    INNER JOIN sala s ON s.id = h.sala_id
                    INNER JOIN turma_disciplina td ON h.turma_disciplina_id = td.id
                    WHERE td.id = '$turmaDisciplina'
                    ORDER BY a.data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT a.*, td.id AS turmaDisciplina, h.dia, h.inicio, h.termino, h.aulas, s.codigo AS sala FROM aula a
                    INNER JOIN horario h ON a.horario_id = h.id
                    INNER JOIN sala s ON s.id = h.sala_id
                    INNER JOIN turma_disciplina td ON h.turma_disciplina_id = td.id
                    WHERE a.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function save($horario, $conteudo, $data, $userCreate) {
        $conection = new Conection();
        $query = "INSERT INTO aula 
                    (horario_id, conteudo, data_aula, data, user_create)
                  VALUES
                  ('$horario', '$conteudo', '$data', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM aula WHERE horario_id = '$horario' AND data_aula = '$data' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $conteudo = $params['conteudo'];
        $query = "UPDATE aula 
                    SET conteudo = '$conteudo' 
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
        $queryFalta = "DELETE FROM falta WHERE aula_id = '$id'";
        $query = "DELETE FROM aula WHERE id = '$id'";
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
?>

