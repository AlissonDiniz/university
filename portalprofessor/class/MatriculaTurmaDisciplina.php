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
require_once '../../config/Conection.php';

class MatriculaTurmaDisciplina {

    public $id;

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

}

?>