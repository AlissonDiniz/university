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
require_once '../../config/Conection.php';

class TurmaDisciplina {

    public $id;

    public function listar($professor) {
        $conection = new Conection();
        $query = "SELECT
                    DISTINCT td.id,
                    td.inicio,
                    td.termino,
                    td.status,
                    pe.codigo AS periodo, d.id AS idDisciplina, d.codigo AS codDisciplina, d.nome AS disciplina
                    FROM turma_disciplina td
                    INNER JOIN turma t ON t.id = td.turma_id
                    INNER JOIN parametros pa ON pa.periodo_atual_id = t.periodo_id
                    INNER JOIN periodo pe ON pe.id = t.periodo_id
                    INNER JOIN horario h ON td.id = h.turma_disciplina_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    WHERE h.professor_id = '$professor' AND td.status = '1'";
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

}

?>
