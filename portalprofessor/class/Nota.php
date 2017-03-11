<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Nota
 *
 * @author Alisson
 */
require_once '../../config/Conection.php';

class Nota {

    public $id;

    public function getToMatriculaTurmaDisciplina($matriculaTurmaDisciplina, $numeroEtapa) {
        $conection = new Conection();
        $query = "SELECT n.* FROM nota n
                    INNER JOIN matricula_turma_disciplina mtd ON n.matricula_turma_disciplina_id = mtd.id  
                    WHERE n.matricula_turma_disciplina_id = '$matriculaTurmaDisciplina' AND 
                          n.numero_etapa = '$numeroEtapa' AND 
                          mtd.status = '1'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function updateByDiario($matriculaTurmaDisciplina, $numeroEtapa, $idNota, $valor, $usuario) {
        $conection = new Conection();
        $valor != "" ? $valorQuery = "'".$valor."'" : $valorQuery = "NULL";
        if ($idNota != "") {
            $query = "UPDATE nota 
                        SET valor = $valorQuery 
                        WHERE id = '$idNota'";
        } else {
            $query = "INSERT INTO nota (matricula_turma_disciplina_id, numero_etapa, valor, data, user_create)
                            VALUES('$matriculaTurmaDisciplina', '$numeroEtapa', $valorQuery, NOW(), '$usuario')";
        }
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>