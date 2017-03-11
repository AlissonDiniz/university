<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Desconto
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Desconto {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM desconto";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar() {
        $conection = new Conection();
        $query = "(SELECT d.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, td.descricao AS tipoDesconto, pa.numero AS parcela FROM desconto d
                    INNER JOIN tipo_desconto td ON td.id = d.tipo_desconto_id
                    INNER JOIN titulo t ON t.id = d.titulo_id
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno al ON al.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                    ORDER BY d.data DESC LIMIT 50)
                  UNION
                  (SELECT d.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, td.descricao AS tipoDesconto, '-' AS parcela FROM desconto d
                    INNER JOIN tipo_desconto td ON td.id = d.tipo_desconto_id
                    INNER JOIN titulo t ON t.id = d.titulo_id
                    INNER JOIN aluno al ON al.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                  ORDER BY d.data DESC LIMIT 50)";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "(SELECT d.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, td.descricao AS tipoDesconto, td.type, pa.numero AS parcela FROM desconto d
                    INNER JOIN tipo_desconto td ON td.id = d.tipo_desconto_id
                    INNER JOIN titulo t ON t.id = d.titulo_id
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno al ON al.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id)
                  UNION
                  (SELECT d.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, td.descricao AS tipoDesconto, td.type, '-' AS parcela FROM desconto d
                    INNER JOIN tipo_desconto td ON td.id = d.tipo_desconto_id
                    INNER JOIN titulo t ON t.id = d.titulo_id
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
        $query = "(SELECT d.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, td.descricao AS tipoDesconto, td.type, pa.numero AS parcela FROM desconto d
                    INNER JOIN tipo_desconto td ON td.id = d.tipo_desconto_id
                    INNER JOIN titulo t ON t.id = d.titulo_id AND t.id = '$titulo'
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno al ON al.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                    ORDER BY d.data DESC LIMIT 50)
                  UNION
                  (SELECT d.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, td.descricao AS tipoDesconto, td.type, '-' AS parcela FROM desconto d
                    INNER JOIN tipo_desconto td ON td.id = d.tipo_desconto_id
                    INNER JOIN titulo t ON t.id = d.titulo_id AND t.id = '$titulo'
                    INNER JOIN aluno al ON al.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                  ORDER BY d.data DESC LIMIT 50)";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "(SELECT d.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, td.descricao AS tipoDesconto, td.type, pa.numero AS parcela FROM desconto d
                    INNER JOIN tipo_desconto td ON td.id = d.tipo_desconto_id
                    INNER JOIN titulo t ON t.id = d.titulo_id
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno al ON al.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                    WHERE d.id = '$id')
                  UNION
                  (SELECT d.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, td.descricao AS tipoDesconto, td.type, '-' AS parcela FROM desconto d
                    INNER JOIN tipo_desconto td ON td.id = d.tipo_desconto_id
                    INNER JOIN titulo t ON t.id = d.titulo_id
                    INNER JOIN aluno al ON al.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                    WHERE d.id = '$id')";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function save($params) {
        $conection = new Conection();
        $titulo = $params['idTitulo'];
        $valor = $params['valor'];
        $tipoDesconto = $params['tipoDesconto'];
        $observacao = $params['observacao'];
        $status = $params['status'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO desconto 
                    (titulo_id, valor, tipo_desconto_id, observacao, status, data, user_create)
                  VALUES
                  ('$titulo', '$valor', '$tipoDesconto', '$observacao', $status, NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM desconto WHERE titulo_id = '$titulo' AND valor = '$valor' AND tipo_desconto_id = '$tipoDesconto' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $valor = $params['valor'];
        $tipoDesconto = $params['tipoDesconto'];
        $observacao = $params['observacao'];
        $status = $params['status'];
        $query = "UPDATE desconto 
                    SET valor = '$valor',
                        tipo_desconto_id = '$tipoDesconto',
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
        $query = "DELETE FROM desconto WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
