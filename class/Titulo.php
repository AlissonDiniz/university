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
require_once '../config/Conection.php';

class Titulo {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM titulo";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function listar() {
        $conection = new Conection();
        $query = "(SELECT t.*, c.id AS idConfiguracao, CONCAT_WS(' - ', c.nome_banco, c.agencia, c.conta) AS configuracao, p.nome, p.cpf, a.matricula FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    ORDER BY t.data DESC LIMIT 25)
                  UNION
                  (SELECT t.*, c.id AS idConfiguracao, CONCAT_WS(' - ', c.nome_banco, c.agencia, c.conta) AS configuracao, p.nome, p.cpf, a.matricula FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    ORDER BY t.data DESC LIMIT 25)";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarLimit($limit) {
        $conection = new Conection();
        $query = "(SELECT t.*, c.id AS idConfiguracao, CONCAT_WS(' - ', c.nome_banco, c.agencia, c.conta) AS configuracao, p.nome, p.cpf, a.matricula FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id)
                  UNION
                  (SELECT t.*, c.id AS idConfiguracao, CONCAT_WS(' - ', c.nome_banco, c.agencia, c.conta) AS configuracao, p.nome, p.cpf, a.matricula FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id)
                    ORDER BY data DESC LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function listarByMatricula($idMatricula) {
        $conection = new Conection();
        $query = "SELECT t.*, c.id AS idConfiguracao, CONCAT_WS(' - ', c.nome_banco, c.agencia, c.conta) AS configuracao, p.nome, p.cpf, a.matricula FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    WHERE m.id = '$idMatricula'
                    ORDER BY t.vencimento LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }
    
    public function listarByAluno($idAluno) {
        $conection = new Conection();
        $query = "SELECT t.*, c.id AS idConfiguracao, CONCAT_WS(' - ', c.nome_banco, c.agencia, c.conta) AS configuracao, p.nome, p.cpf, a.matricula FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    WHERE a.id = '$idAluno'
                    ORDER BY t.vencimento LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "(SELECT t.*, c.id AS idConfiguracao, CONCAT_WS(' - ', c.nome_banco, c.agencia, c.conta) AS configuracao, p.nome, p.cpf, a.id AS aluno, a.matricula, pa.id AS parcela FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    LEFT JOIN parcela pa ON pa.id = t.parcela_id
                    WHERE t.id = '$id')
                  UNION
                  (SELECT t.*, c.id AS idConfiguracao, CONCAT_WS(' - ', c.nome_banco, c.agencia, c.conta) AS configuracao, p.nome, p.cpf, a.id AS aluno, a.matricula, pa.id AS parcela FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    LEFT JOIN parcela pa ON pa.id = t.parcela_id
                    WHERE t.id = '$id')";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function findByNossoNumero($nossoNumero) {
        $conection = new Conection();
        $query = "SELECT t.*, c.id AS idConfiguracao, CONCAT_WS(' - ', c.nome_banco, c.agencia, c.conta) AS configuracao, ar.nosso_numero AS nossoNumeroBanco FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    LEFT JOIN arquivo_row ar ON ar.numero_documento = t.nosso_numero AND ar.id_ocorrencia = '2'
                    WHERE t.nosso_numero = '$nossoNumero'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function findByMatricula($matricula) {
        $conection = new Conection();
        $query = "SELECT * FROM titulo WHERE matricula_id = '$matricula'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function findByAlunoParcela($aluno, $parcela, $periodo) {
        $conection = new Conection();
        $query = "SELECT t.*, c.id AS idConfiguracao, CONCAT_WS(' - ', c.nome_banco, c.agencia, c.conta) AS configuracao, ar.nosso_numero AS nossoNumeroBanco FROM titulo t
                    INNER JOIN configuracao c ON c.id = t.configuracao_id
                    INNER JOIN matricula m ON m.aluno_id = '$aluno' AND m.id = t.matricula_id AND m.periodo_id = '$periodo'
                    INNER JOIN parcela p ON p.id = t.parcela_id
                    LEFT JOIN arquivo_row ar ON ar.numero_documento = t.nosso_numero AND ar.id_ocorrencia = '2'
                    WHERE p.numero = '$parcela'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function isExistTitulo($idMatricula, $idParcela) {
        $conection = new Conection();
        $query = "SELECT id FROM titulo WHERE matricula_id = '$idMatricula' AND parcela_id = '$idParcela'";
        $result = $conection->selectQuery($query);
        if ($conection->rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getMaxNossoNumero() {
        $conection = new Conection();
        $query = "SELECT MAX(nosso_numero) FROM titulo";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }

    public function save($params) {
        $conection = new Conection();
        $parcela = $params['parcela'];
        $matricula = $params['matricula'];
        $configuracao = $params['configuracao'];
        $nossoNumero = $params['nossoNumero'];
        $valor = $params['valor'];
        $vencimento = $params['vencimento'];
        $situacao = $params['situacao'];
        $status = $params['status'];
        $linhaDigitavel = $params['linhaDigitavel'];
        $observacao = $params['observacao'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO titulo 
                    (parcela_id, matricula_id, configuracao_id, nosso_numero, linha_digitavel, valor, valor_restante, vencimento, situacao, status, observacao, data, user_create)
                  VALUES
                  ('$parcela', '$matricula', '$configuracao', '$nossoNumero', '$linhaDigitavel', '$valor', '$valor', '$vencimento', '$situacao', $status, '$observacao', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM titulo WHERE parcela_id = '$parcela' AND nosso_numero = '$nossoNumero' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function saveByAluno($params) {
        $conection = new Conection();
        $aluno = $params['aluno'];
        $nossoNumero = $params['nossoNumero'];
        $configuracao = $params['configuracao'];
        $valor = $params['valor'];
        $vencimento = $params['vencimento'];
        $situacao = $params['situacao'];
        $status = $params['status'];
        $linhaDigitavel = $params['linhaDigitavel'];
        $observacao = $params['observacao'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO titulo 
                    (aluno_id, configuracao_id, nosso_numero, linha_digitavel, valor, valor_restante, vencimento, situacao, status, observacao, data, user_create)
                  VALUES
                  ('$aluno', '$configuracao', '$nossoNumero', '$linhaDigitavel', '$valor', '$valor', '$vencimento', '$situacao', $status, '$observacao', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM titulo WHERE aluno_id = '$aluno' AND nosso_numero = '$nossoNumero' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function updateSituacao($id) {
        $conection = new Conection();
        $query = "SELECT * FROM acrescimo WHERE titulo_id = '$id' AND status = '1'";
        $result = $conection->selectQuery($query);
        $valorAcrescimo = 0;
        while ($array = $conection->fetch($result)) {
            $valorAcrescimo = $valorAcrescimo + $array['valor'];
        }
        
        $query = "SELECT * FROM baixa WHERE titulo_id = '$id'";
        $result = $conection->selectQuery($query);
        $valorBaixa = 0;
        while ($array = $conection->fetch($result)) {
            $valorBaixa = $valorBaixa + $array['valor_pago'];
        }
        
        $query = "SELECT * FROM desconto d
                    INNER JOIN tipo_desconto td ON d.tipo_desconto_id = td.id AND td.type LIKE '%1' 
                    WHERE d.titulo_id = '$id'";
        $result = $conection->selectQuery($query);
        $valorDesconto = 0;
        while ($array = $conection->fetch($result)) {
            $valorDesconto = $valorDesconto + $array['valor'];
        }
        
        $titulo = $this->get($id);
        $valorTitulo = ($titulo['dados']['valor'] + $titulo['dados']['valor_multa'] + $titulo['dados']['valor_juros']) - $titulo['dados']['valor_desconto'];
        $valorTituloRestante = ($valorTitulo + $valorAcrescimo) - $valorDesconto;
        
        if ($valorBaixa > 0 || $titulo['dados']['valor_desconto'] > 0) {
            if ($valorBaixa >= $valorTituloRestante) {
                $query = "UPDATE titulo 
                    SET situacao = 'B',
                    valor_restante = '0'
                  WHERE id = '$id'";
            } else {
                $query = "UPDATE titulo 
                    SET situacao = 'P',
                    valor_restante = '" . ($valorTituloRestante - $valorBaixa) . "'
                  WHERE id = '$id'";
            }
        } else {
            $query = "UPDATE titulo 
                    SET situacao = 'A',
                    valor_multa = '0',
                    valor_juros = '0', 
                    valor_desconto = '0',
                    valor_restante = '" . ($valorTituloRestante) . "'
                  WHERE id = '$id'";
        }

        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $retorno = true;
        $id = $params['id'];

        $arrayTitulo = $this->get($id);
        if ($arrayTitulo['dados']['valor'] != $params['valor']) {
            $valorRestante = ($arrayTitulo['dados']['valor_restante'] + ($params['valor'] - $arrayTitulo['dados']['valor']));
            $valorRestanteQuery = "valor_restante = '" . $valorRestante . "', ";
        } else {
            if (isset($params['valor_restante']) && $arrayTitulo['dados']['valor_restante'] != $params['valor_restante']) {
                $valorRestante = $params['valor_restante'];
                $valorRestanteQuery = "valor_restante = '" . $valorRestante . "', ";
            } else {
                $valorRestante = 1;
                $valorRestanteQuery = "";
            }
        }

        $configuracao = $params['configuracao'];
        $valor = $params['valor'];
        $vencimento = $params['vencimento'];
        $status = $params['status'];
        $observacao = $params['observacao'];

        if ($valor > 0) {
            if ($valorRestante > 0) {
                if ($arrayTitulo['dados']['situacao'] == "B") {
                    $situacao = "situacao = 'A', ";
                } else {
                    $situacao = "";
                }
            } else {
                $situacao = "situacao = 'B', ";
            }
        } else {
            $situacao = "situacao = 'B', ";
        }

        $query = "UPDATE titulo 
                    SET valor = '$valor', $valorRestanteQuery
                    configuracao_id = '$configuracao',
                    vencimento = '$vencimento',
                    status = '$status', $situacao
                    observacao = '$observacao'
                  WHERE id = '$id'";
        if (!$conection->executeUpdate($query) && !$this->updateSituacao($id)) {
            $retorno = false;
        }
        $this->id = $id;
        return $retorno;
    }

    public function updateValores($params) {
        $conection = new Conection();
        $retorno = true;
        $id = $params['idTitulo'];
        $valorMulta = $params['valorMulta'];
        $valorJuros = $params['valorJuros'];
        $valorDesconto = $params['valorDesconto'];
        $query = "UPDATE titulo 
                    SET valor_multa = '$valorMulta', 
                        valor_juros = '$valorJuros', 
                        valor_desconto = '$valorDesconto'
                  WHERE id = '$id'";
        if (!$conection->executeUpdate($query) && !$this->updateSituacao($id)) {
            $retorno = false;
        }
        $this->id = $id;
        return $retorno;
    }

    public function updateStatus($params) {
        $conection = new Conection();
        $retorno = true;
        $id = $params['id'];
        $status = $params['status'];
        $query = "UPDATE titulo 
                    SET status = '$status'
                  WHERE id = '$id'";
        if (!$conection->executeUpdate($query) && !$this->updateSituacao($id)) {
            $retorno = false;
        }
        $this->id = $id;
        return $retorno;
    }

    public function delete($params) {
        $conection = new Conection();
        $id = $params['id'];
        $query = "DELETE FROM titulo WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
