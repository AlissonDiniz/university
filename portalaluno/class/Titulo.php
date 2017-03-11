<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Titulo
 *
 * @author Alisson
 */
require_once '../../config/Conection.php';

class Titulo {

    public $id;

    public function count($idAluno) {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM
                  (SELECT t.id FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    WHERE a.id = '$idAluno'
                  UNION
                  SELECT t.id FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                   WHERE a.id = '$idAluno')
                  AS U";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listarLimit($idAluno, $limit) {
        $conection = new Conection();
        $query = "(SELECT t.*, c.id AS idConfiguracao, CONCAT_WS(' - ', c.nome_banco, c.agencia, c.conta) AS configuracao, p.nome, p.cpf, a.matricula FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    WHERE a.id = '$idAluno')
                  UNION
                  (SELECT t.*, c.id AS idConfiguracao, CONCAT_WS(' - ', c.nome_banco, c.agencia, c.conta) AS configuracao, p.nome, p.cpf, a.matricula FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                   WHERE a.id = '$idAluno')
                  ORDER BY vencimento DESC LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "(SELECT t.*, c.id AS idConfiguracao, CONCAT_WS(' - ', c.nome_banco, c.agencia, c.conta) AS configuracao, p.nome, p.cpf, a.matricula, pa.id AS parcela FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    LEFT JOIN parcela pa ON pa.id = t.parcela_id
                    WHERE t.id = '$id')
                  UNION
                  (SELECT t.*, c.id AS idConfiguracao, CONCAT_WS(' - ', c.nome_banco, c.agencia, c.conta) AS configuracao, p.nome, p.cpf, a.matricula, pa.id AS parcela FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    LEFT JOIN parcela pa ON pa.id = t.parcela_id
                    WHERE t.id = '$id')";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

}

?>
