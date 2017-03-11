<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Aluno
 *
 * @author Alisson
 */
require_once '../../config/Conection.php';

class Aluno {

    public $id;

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT a.*, p.nome, p.cpf, c.nome AS nomeCurso FROM aluno a
                    INNER JOIN grade g ON g.id = a.grade_id
                    INNER JOIN curso c ON c.id = g.curso_id
                    INNER JOIN pessoa p ON a.pessoa_id = p.id WHERE a.id = '$id'";
        $result = $conection->selectQuery($query);
        $this->id = $id;
        return array("dados" => $conection->fetch($result));
    }

    public function updatePassword($params) {
        $conection = new Conection();
        $id = $params['id'];
        $password = $params['password'];
        $query = "UPDATE aluno 
                    SET password = '$password'
                  WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $this->id = $id;
        return true;
    }

}

?>
