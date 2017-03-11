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
require_once '../config/Conection.php';

class Aluno {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM aluno";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar() {
        $conection = new Conection();
        $query = "SELECT a.*, p.nome, p.cpf FROM aluno a
                    INNER JOIN pessoa p ON a.pessoa_id = p.id
                    ORDER BY a.data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "SELECT a.*, p.nome, p.cpf FROM aluno a
                    INNER JOIN pessoa p ON a.pessoa_id = p.id
                    ORDER BY a.data DESC LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT a.*, p.nome, p.cpf, c.nome AS nomeCurso FROM aluno a
                    INNER JOIN grade g ON g.id = a.grade_id
                    INNER JOIN curso c ON c.id = g.curso_id
                    INNER JOIN pessoa p ON a.pessoa_id = p.id WHERE a.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function getByMatricula($idMatricula) {
        $conection = new Conection();
        $query = "SELECT a.*, p.nome, p.cpf, c.nome AS nomeCurso FROM aluno a
                    INNER JOIN grade g ON g.id = a.grade_id
                    INNER JOIN curso c ON c.id = g.curso_id
                    INNER JOIN pessoa p ON a.pessoa_id = p.id 
                    INNER JOIN matricula m ON m.aluno_id = a.id
                    WHERE m.id = '$idMatricula'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function createMatricula($matricula) {
        $conection = new Conection();
        $query = "SELECT matricula FROM aluno WHERE matricula LIKE '" . $matricula . "____' ORDER BY matricula DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        if ($conection->rows($result) > 0) {
            $array = $conection->fetch($result);
            return $matricula . sprintf("%04d", (substr($array[0], 6, 4) + 1));
        } else {
            return $matricula . "0001";
        }
    }

    public function save($params) {
        $conection = new Conection();
        $pessoa = $params['pessoa'];
        $responsavel = $params['responsavel'];
        $matricula = $params['matricula'];
        $modulo = $params['modulo'];
        $periodoIngresso = $params['periodoIngresso'];
        $observacao = $params['observacao'];
        $grade = $params['grade'];
        $formaIngresso = $params['formaIngresso'];
        $turno = $params['turno'];
        $situacao = $params['situacao'];
        $status = $params['status'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO aluno 
                    (pessoa_id, responsavel_id, periodo_ingresso_id, grade_id, matricula, forma_ingresso, modulo, turno, username, password, observacao, situacao, status, data, user_create)
                  VALUES
                  ('$pessoa', '$responsavel', '$periodoIngresso', '$grade', '$matricula', '$formaIngresso', '$modulo', '$turno', '$matricula', '" . sha1($matricula) . "', '$observacao', '$situacao', $status, NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM aluno WHERE pessoa_id = '$pessoa' AND periodo_ingresso_id = '$periodoIngresso' AND grade_id = '$grade' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $responsavel = $params['responsavel'];
        $formaIngresso = $params['formaIngresso'];
        $turno = $params['turno'];
        $modulo = $params['modulo'];
        $observacao = $params['observacao'];
        $situacao = $params['situacao'];
        $status = $params['status'];
        $query = "UPDATE aluno 
                    SET forma_ingresso = '$formaIngresso', 
                        responsavel_id = '$responsavel',
                        turno = '$turno', 
                        modulo = '$modulo', 
                        observacao = '$observacao', 
                        situacao = '$situacao',
                        status = $status
                  WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $this->id = $id;
        return true;
    }

    public function updateModulo($params) {
        $conection = new Conection();
        $id = $params['id'];
        $modulo = $params['modulo'];
        $query = "UPDATE aluno 
                    SET modulo = '$modulo'
                  WHERE id = '$id'";
        echo $query;
        die();
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $this->id = $id;
        return true;
    }

    public function updateAtividade($params) {
        $conection = new Conection();
        $id = $params['id'];
        $quantidadeAtividade = $params['quantidadeAtividade'];
        $statusAtividade = $params['statusAtividade'];
        $query = "UPDATE aluno 
                    SET quantidade_atividade = '$quantidadeAtividade', 
                        status_atividade = '$statusAtividade'
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
        $query = "DELETE FROM aluno WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
