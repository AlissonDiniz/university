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
require_once '../../config/Conection.php';

class Horario {

    public $id;

    public function listar($professor, $turmaDisciplina) {
        $conection = new Conection();
        $query = "SELECT h.*, td.horario AS tipoHorario, s.codigo AS sala, pe.nome AS professor FROM horario h
                    INNER JOIN sala s ON s.id = h.sala_id
                    INNER JOIN turma_disciplina td ON h.turma_disciplina_id = td.id
                    INNER JOIN turma t ON t.id = td.turma_id
                    INNER JOIN professor p ON p.id = h.professor_id
                    INNER JOIN pessoa pe ON pe.id = p.pessoa_id
                    WHERE h.turma_disciplina_id LIKE '$turmaDisciplina' AND p.id =  '$professor'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

}

?>
