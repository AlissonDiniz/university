<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Acrescimo
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Acrescimo {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM acrescimo";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar() {
        $conection = new Conection();
        $query = "(SELECT a.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, pa.numero AS parcela FROM acrescimo a
                    INNER JOIN titulo t ON t.id = a.titulo_id
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno al ON al.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                    ORDER BY a.data DESC LIMIT 50)
                  UNION
                  (SELECT a.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, '-' AS parcela FROM acrescimo a
                    INNER JOIN titulo t ON t.id = a.titulo_id
                    INNER JOIN aluno al ON al.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                  ORDER BY a.data DESC LIMIT 50)";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "(SELECT a.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, pa.numero AS parcela FROM acrescimo a
                    INNER JOIN titulo t ON t.id = a.titulo_id
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno al ON al.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id)
                  UNION
                  (SELECT a.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, '-' AS parcela FROM acrescimo a
                    INNER JOIN titulo t ON t.id = a.titulo_id
                    INNER JOIN aluno al ON al.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id)
                  ORDER BY data DESC LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarByTitulo($titulo) {
        $conection = new Conection();
        $query = "(SELECT a.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, pa.numero AS parcela FROM acrescimo a
                    INNER JOIN titulo t ON t.id = a.titulo_id AND t.id = '$titulo'
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno al ON al.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                    ORDER BY a.data DESC LIMIT 50)
                  UNION
                  (SELECT a.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, '-' AS parcela FROM acrescimo a
                    INNER JOIN titulo t ON t.id = a.titulo_id AND t.id = '$titulo'
                    INNER JOIN aluno al ON al.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                  ORDER BY a.data DESC LIMIT 50)";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "(SELECT a.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, pa.numero AS parcela FROM acrescimo a
                    INNER JOIN titulo t ON t.id = a.titulo_id
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno al ON al.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                    WHERE a.id = '$id')
                 UNION
                  (SELECT a.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, '-' AS parcela FROM acrescimo a
                    INNER JOIN titulo t ON t.id = a.titulo_id
                    INNER JOIN aluno al ON al.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                 WHERE a.id = '$id')";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function save($params) {
        $conection = new Conection();
        $titulo = $params['idTitulo'];
        $observacao = $params['observacao'];
        $valor = $params['valor'];
        $status = $params['status'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO acrescimo 
                    (titulo_id, valor, observacao, status, data, user_create)
                  VALUES
                  ('$titulo', '$valor', '$observacao', $status, NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM acrescimo WHERE titulo_id = '$titulo' AND valor = '$valor' AND observacao = '$observacao' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $valor = $params['valor'];
        $observacao = $params['observacao'];
        $status = $params['status'];
        $query = "UPDATE acrescimo 
                    SET valor = '$valor', 
                        observacao = '$observacao', 
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
        $query = "DELETE FROM acrescimo WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
