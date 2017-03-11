<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Baixa
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Baixa {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM baixa";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar() {
        $conection = new Conection();
        $query = "(SELECT b.*, u.nome AS userName, t.nosso_numero, fp.descricao AS formaPagamento, p.nome, a.matricula FROM baixa b
                    INNER JOIN usuario u ON u.username = b.user_create
                    INNER JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    INNER JOIN titulo t ON t.id = b.titulo_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    LEFT JOIN parcela pa ON pa.id = t.parcela_id)
                  UNION
                  (SELECT b.*, u.nome AS userName, t.nosso_numero, fp.descricao AS formaPagamento, p.nome, a.matricula FROM baixa b 
                    INNER JOIN usuario u ON u.username = b.user_create
                    INNER JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    INNER JOIN titulo t ON t.id = b.titulo_id
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    LEFT JOIN parcela pa ON pa.id = t.parcela_id)
                   ORDER BY data DESC LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "(SELECT b.*, u.nome AS userName, t.nosso_numero, fp.descricao AS formaPagamento, p.nome, a.matricula FROM baixa b
                    INNER JOIN usuario u ON u.username = b.user_create
                    INNER JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    INNER JOIN titulo t ON t.id = b.titulo_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    LEFT JOIN parcela pa ON pa.id = t.parcela_id)
                  UNION
                  (SELECT b.*, u.nome AS userName, t.nosso_numero, fp.descricao AS formaPagamento, p.nome, a.matricula FROM baixa b 
                    INNER JOIN usuario u ON u.username = b.user_create
                    INNER JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    INNER JOIN titulo t ON t.id = b.titulo_id
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    LEFT JOIN parcela pa ON pa.id = t.parcela_id)
                  ORDER BY data DESC LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarByTitulo($idTitulo) {
        $conection = new Conection();
        $query = "(SELECT b.*, u.nome AS userName, t.nosso_numero, fp.descricao AS formaPagamento, p.nome, a.matricula FROM baixa b
                    INNER JOIN usuario u ON u.username = b.user_create
                    INNER JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    INNER JOIN titulo t ON t.id = b.titulo_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    LEFT JOIN parcela pa ON pa.id = t.parcela_id WHERE t.id = '$idTitulo')
                  UNION
                  (SELECT b.*, u.nome AS userName, t.nosso_numero, fp.descricao AS formaPagamento, p.nome, a.matricula FROM baixa b 
                    INNER JOIN usuario u ON u.username = b.user_create
                    INNER JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    INNER JOIN titulo t ON t.id = b.titulo_id
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    LEFT JOIN parcela pa ON pa.id = t.parcela_id WHERE t.id = '$idTitulo')";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "(SELECT b.*, u.nome AS userName, uUP.nome AS userUpdate, t.id AS titulo, t.nosso_numero, t.valor_restante AS valorTitulo, t.valor_multa, t.valor_juros, t.valor_desconto, fp.descricao AS formaPagamento, t.valor, p.nome, a.matricula FROM baixa b 
                    INNER JOIN usuario u ON u.username = b.user_create
                    LEFT JOIN usuario uUP ON uUP.username = b.user_update
                    INNER JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    INNER JOIN titulo t ON t.id = b.titulo_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                   WHERE b.id = '$id')
                  UNION
                  (SELECT b.*, u.nome AS userName, uUP.nome AS userUpdate, t.id AS titulo, t.nosso_numero, t.valor_restante AS valorTitulo, t.valor_multa, t.valor_juros, t.valor_desconto, fp.descricao AS formaPagamento, t.valor, p.nome, a.matricula FROM baixa b 
                    INNER JOIN usuario u ON u.username = b.user_create
                    LEFT JOIN usuario uUP ON uUP.username = b.user_update
                    INNER JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    INNER JOIN titulo t ON t.id = b.titulo_id
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                   WHERE b.id = '$id')";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function save($params) {
        $conection = new Conection();
        $idTitulo = $params['idTitulo'];
        $formaPagamento = $params['formaPagamento'];
        $valorPago = $params['valorPago'];
        $dataPagamento = $params['dataPagamento'];
        $observacao = $params['observacao'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO baixa 
                    (titulo_id, data_pagamento, valor_pago, forma_pagamento_id, observacao, data, user_create)
                  VALUES
                  ('$idTitulo', '$dataPagamento', '$valorPago', '$formaPagamento', '$observacao', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM baixa WHERE titulo_id = '$idTitulo' AND data_pagamento = '$dataPagamento' AND  valor_pago = '$valorPago' AND forma_pagamento_id = '$formaPagamento' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function saveByArquivo($params) {
        $conection = new Conection();
        $idTitulo = $params['idTitulo'];
        $bancoRecebedor = $params['bancoRecebedor'];
        $agenciaRecebedor = $params['agenciaRecebedor'];
        $idArquivoRow = $params['idArquivoRow'];
        $formaPagamento = $params['formaPagamento'];
        $valorPago = $params['valorPago'];
        $dataPagamento = $params['dataPagamento'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO baixa 
                    (titulo_id, data_pagamento, valor_pago, forma_pagamento_id, banco, agencia, arquivo_row_id, observacao, data, user_create)
                  VALUES
                  ('$idTitulo', '$dataPagamento', '$valorPago', '$formaPagamento', '$bancoRecebedor', '$agenciaRecebedor', '$idArquivoRow', ' ', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM baixa WHERE titulo_id = '$idTitulo' AND data_pagamento = '$dataPagamento' AND  valor_pago = '$valorPago' AND forma_pagamento_id = '$formaPagamento' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $formaPagamento = $params['formaPagamento'];
        $valorPago = $params['valorPago'];
        $dataPagamento = $params['dataPagamento'];
        $observacao = $params['observacao'];
        $userUpdate = $params['userCreate'];
        $query = "UPDATE baixa 
                    SET forma_pagamento_id = '$formaPagamento', 
                        data_pagamento = '$dataPagamento', 
                        valor_pago = '$valorPago',  
                        observacao = '$observacao', 
                        user_update = '$userUpdate',
                        data_update = NOW()
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
        $query = "DELETE FROM baixa WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
