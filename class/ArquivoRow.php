<?php

/**
 * Description of ArquivoRow
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class ArquivoRow {

    public $id;

    public function listar($idArquivo) {
        $conection = new Conection();
        $query = "SELECT s.* FROM ((SELECT ar.*, u.nome AS usuario, b.valor_pago, p.nome, p.cpf, a.matricula FROM arquivo_row ar
                  INNER JOIN usuario u ON u.username = ar.user_create
                  INNER JOIN baixa b ON b.arquivo_row_id = ar.id
                  INNER JOIN titulo t ON t.id = b.titulo_id
                  INNER JOIN matricula m ON t.matricula_id = m.id
                  INNER JOIN aluno a ON a.id = m.aluno_id
                  INNER JOIN pessoa p ON p.id = a.pessoa_id
                  WHERE ar.arquivo_id = '$idArquivo')
                UNION
                  (SELECT ar.*, u.nome AS usuario, b.valor_pago, p.nome, p.cpf, a.matricula FROM arquivo_row ar
                  INNER JOIN usuario u ON u.username = ar.user_create
                  INNER JOIN baixa b ON b.arquivo_row_id = ar.id
                  INNER JOIN titulo t ON t.id = b.titulo_id
                  INNER JOIN aluno a ON a.id = t.aluno_id
                  INNER JOIN pessoa p ON p.id = a.pessoa_id
                  WHERE ar.arquivo_id = '$idArquivo')
                UNION
                  (SELECT ar.*, '', '', '', '', '' FROM arquivo_row ar 
                  INNER JOIN usuario u ON u.username = ar.user_create
                  WHERE ar.arquivo_id = '$idArquivo')) s
                GROUP BY s.id";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function save($params) {
        $conection = new Conection();
        $idArquivo = $params['idArquivo'];
        $nossoNumero = $params['nossoNumero'];
        $numeroDocumento = $params['numeroDocumento'];
        $idOcorrencia = $params['idOcorrencia'];
        $descricaoOcorrencia = $params['descricaoOcorrencia'];
        $dataOcorrencia = $params['dataOcorrencia'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO arquivo_row
                    (arquivo_id, id_ocorrencia, descricao_ocorrencia, data_ocorrencia, nosso_numero, numero_documento, data, user_create)
                  VALUES
                  ('$idArquivo', '$idOcorrencia', '$descricaoOcorrencia', '$dataOcorrencia', '$nossoNumero', '$numeroDocumento', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM arquivo_row WHERE arquivo_id = '$idArquivo' AND id_ocorrencia = '$idOcorrencia' AND nosso_numero = '$nossoNumero' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function updateOcorrencia($params) {
        $conection = new Conection();
        $id = $params['id'];
        $descricaoOcorrencia = $params['descricaoOcorrencia'];
        $query = "UPDATE arquivo_row 
                    SET descricao_ocorrencia = '$descricaoOcorrencia'
                  WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $this->id = $id;
        return true;
    }

}

?>