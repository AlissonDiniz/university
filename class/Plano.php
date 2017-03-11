<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Plano
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Plano {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM plano";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar() {
        $conection = new Conection();
        $query = "SELECT p.*, pe.codigo AS periodo, co.nome_banco AS banco, co.agencia, co.conta, c.nome AS curso FROM plano p
                    INNER JOIN configuracao co ON co.id = p.configuracao_id
                    INNER JOIN periodo pe ON pe.id = p.periodo_id
                    INNER JOIN curso c ON c.id = p.curso_id
                    ORDER BY p.data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "SELECT p.*, pe.codigo AS periodo, co.nome_banco AS banco, co.agencia, co.conta, c.nome AS curso FROM plano p
                    INNER JOIN configuracao co ON co.id = p.configuracao_id
                    INNER JOIN periodo pe ON pe.id = p.periodo_id
                    INNER JOIN curso c ON c.id = p.curso_id
                    ORDER BY p.data DESC LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT p.*, pe.codigo AS periodo, co.nome_banco AS banco, co.agencia, co.conta, c.nome AS curso FROM plano p
                    INNER JOIN configuracao co ON co.id = p.configuracao_id
                    INNER JOIN periodo pe ON pe.id = p.periodo_id
                    INNER JOIN curso c ON c.id = p.curso_id
                    WHERE p.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function getToAluno($id, $periodo) {
        $conection = new Conection();
        $query = "SELECT p.id, p.descricao, c.codigo AS codCurso, co.nome_banco AS banco, co.agencia, co.conta, c.nome AS curso FROM plano p
                    INNER JOIN configuracao co ON co.id = p.configuracao_id
                    INNER JOIN curso c ON c.id = p.curso_id
                    INNER JOIN grade g ON g.curso_id = p.curso_id
                    INNER JOIN periodo pe ON pe.id = p.periodo_id
                    INNER JOIN aluno a ON a.grade_id = g.id
                    WHERE a.id = '$id' AND p.periodo_id = '$periodo'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();

        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("id" => $array['id'], "codigo" => $array['codCurso'] . " - " . $array['descricao']);
        }
        return $arrayRetorno;
    }

    public function getToTurma($id, $periodo) {
        $conection = new Conection();
        $query = "SELECT p.id, p.descricao, c.codigo AS codCurso, co.nome_banco AS banco, co.agencia, co.conta, c.nome AS curso FROM plano p
                    INNER JOIN configuracao co ON co.id = p.configuracao_id
                    INNER JOIN curso c ON c.id = p.curso_id
                    INNER JOIN grade g ON g.curso_id = p.curso_id
                    INNER JOIN periodo pe ON pe.id = p.periodo_id
                    INNER JOIN turma t ON t.grade_id = g.id
                    WHERE t.id = '$id' AND p.periodo_id = '$periodo'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();

        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("id" => $array['id'], "codigo" => $array['codCurso'] . " - " . $array['descricao']);
        }
        return $arrayRetorno;
    }

    public function save($params) {
        $conection = new Conection();
        $configuracao = $params['configuracao'];
        $periodo = $params['periodo'];
        $curso = $params['curso'];
        $valor = $params['valor'];
        $parcelas = $params['parcelas'];
        $status = $params['status'];
        $descricao = $params['descricao'];
        $observacao = $params['observacao'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO plano 
                    (configuracao_id, curso_id, periodo_id, descricao, valor, quantidade_parcelas, observacao, status, data, user_create)
                  VALUES
                  ('$configuracao', '$curso', '$periodo', '$descricao', '$valor', '$parcelas', '$observacao', '$status', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM plano WHERE configuracao_id = '$configuracao' AND curso_id = '$curso' AND periodo_id = '$periodo' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $valor = $params['valor'];
        $parcelas = $params['parcelas'];
        $status = $params['status'];
        $descricao = $params['descricao'];
        $observacao = $params['observacao'];
        $query = "UPDATE plano 
                    SET observacao = '$observacao',
                        descricao = '$descricao',
                        valor = '$valor',
                        quantidade_parcelas = '$parcelas',
                        status = $status
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
        $query = "DELETE FROM plano WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
