<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pessoa
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Pessoa {

    public $id;

    public function count() {
        $conection = new Conection();
        $query = "SELECT COUNT(*) FROM pessoa";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        return $array[0];
    }
    
    public function listar($limit) {
        $conection = new Conection();
        $query = "SELECT * FROM pessoa ORDER BY data DESC LIMIT $limit";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT * FROM pessoa WHERE id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }
    
    public function getByMatricula($id) {
        $conection = new Conection();
        $query = "SELECT id, cpf, nome FROM pessoa WHERE id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function getByCPF($cpf) {
        $conection = new Conection();
        $query = "SELECT * FROM pessoa WHERE cpf = '$cpf'";
        $result = $conection->selectQuery($query);
        if ($conection->rows($result) > 0) {
            return array("dados" => $conection->fetch($result));
        } else {
            return array("dados" => null);
        }
    }
    
    public function validateCPF($cpf) {
        $conection = new Conection();
        $query = "SELECT * FROM pessoa WHERE cpf = '$cpf'";
        $result = $conection->selectQuery($query);
        if ($conection->rows($result) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function save($params) {
        $conection = new Conection();
        $cpf = $params['cpf'];
        $nome = $params['nome'];
        $sexo = $params['sexo'];
        $estadoCivil = $params['estadoCivil'];
        $dataNascimento = $params['dataNascimento'];
        $identidade = $params['identidade'];
        $orgaoEmissorIdentidade = $params['orgaoEmissorIdentidade'];
        $estadoIdentidade = $params['estadoIdentidade'];
        if ($params['dataIdentidade'] != "") {
            $labelDataIdentidade = "data_identidade,";
            $dataIdentidade = "'" . $params['dataIdentidade'] . "',";
        } else {
            $labelDataIdentidade = "";
            $dataIdentidade = "";
        }
        $tituloEleitoral = $params['tituloEleitoral'];
        $zona = $params['zona'];
        $secao = $params['secao'];
        $pispasep = $params['pispasep'];
        $naturalidade = $params['naturalidade'];
        $nacionalidade = $params['nacionalidade'];
        $nomePai = $params['nomePai'];
        $cpfPai = $params['cpfPai'];
        $nomeMae = $params['nomeMae'];
        $cpfMae = $params['cpfMae'];
        $cep = $params['cep'];
        $logradouro = $params['logradouro'];
        $numero = $params['numero'];
        $complemento = $params['complemento'];
        $bairro = $params['bairro'];
        $cidade = $params['cidade'];
        $estado = $params['estado'];
        $telefone1 = $params['telefone1'];
        $telefone2 = $params['telefone2'];
        $email = $params['email'];
        $formacao = $params['formacao'];
        $ocupacao = $params['ocupacao'];
        $canhoto = $params['canhoto'];
        $deficiente = $params['deficiencia'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO pessoa 
                    (cpf, nome, data_nascimento, identidade, orgao_emissor_identidade,
                        sexo, estado_civil, estado_identidade, $labelDataIdentidade
                        titulo_eleitoral, zona, secao, pispasep, naturalidade,
                        nacionalidade, nome_pai, cpf_pai, nome_mae, cpf_mae, 
                        cep, logradouro, numero, complemento, bairro,
                        cidade, estado, telefone1, telefone2, email, formacao, ocupacao, 
                        canhoto, deficiente, data, user_create)
                  VALUES
                  ('$cpf', '$nome', '$dataNascimento', '$identidade', '$orgaoEmissorIdentidade',
                   '$sexo', '$estadoCivil', '$estadoIdentidade', $dataIdentidade '$tituloEleitoral',
                   '$zona', '$secao', '$pispasep', '$naturalidade', '$nacionalidade', '$nomePai', '$cpfPai',
                   '$nomeMae', '$cpfMae', '$cep', '$logradouro', '$numero', '$complemento',
                   '$bairro', '$cidade', '$estado', '$telefone1', '$telefone2', '$email', '$formacao', '$ocupacao', 
                   '$canhoto', '$deficiente', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        $query = "SELECT id FROM pessoa WHERE cpf = '$cpf' AND nome = '$nome' AND data_nascimento = '$dataNascimento' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $cpf = $params['cpf'];
        $nome = $params['nome'];
        $sexo = $params['sexo'];
        $estadoCivil = $params['estadoCivil'];
        if ($params['dataIdentidade'] != "") {
            $labelDataNascimento = "data_nascimento = ";
            $dataNascimento = "'" . $params['dataNascimento'] . "',";
        } else {
            $labelDataIdentidade = "";
            $dataNascimento = "";
        }
        $identidade = $params['identidade'];
        $orgaoEmissorIdentidade = $params['orgaoEmissorIdentidade'];
        $estadoIdentidade = $params['estadoIdentidade'];
        if ($params['dataIdentidade'] != "") {
            $labelDataIdentidade = "data_identidade = ";
            $dataIdentidade = "'" . $params['dataIdentidade'] . "',";
        } else {
            $labelDataIdentidade = "";
            $dataIdentidade = "";
        }
        $tituloEleitoral = $params['tituloEleitoral'];
        $zona = $params['zona'];
        $secao = $params['secao'];
        $pispasep = $params['pispasep'];
        $naturalidade = $params['naturalidade'];
        $nacionalidade = $params['nacionalidade'];
        $nomePai = $params['nomePai'];
        $cpfPai = $params['cpfPai'];
        $nomeMae = $params['nomeMae'];
        $cpfMae = $params['cpfMae'];
        $cep = $params['cep'];
        $logradouro = $params['logradouro'];
        $numero = $params['numero'];
        $complemento = $params['complemento'];
        $bairro = $params['bairro'];
        $cidade = $params['cidade'];
        $estado = $params['estado'];
        $telefone1 = $params['telefone1'];
        $telefone2 = $params['telefone2'];
        $email = $params['email'];
        $formacao = $params['formacao'];
        $ocupacao = $params['ocupacao'];
        $canhoto = $params['canhoto'];
        $deficiente = $params['deficiencia'];
        $query = "UPDATE pessoa 
                    SET nome = '$nome',
                        cpf = '$cpf',
                        $labelDataNascimento$dataNascimento
                        sexo = '$sexo', 
                        estado_civil = '$estadoCivil',
                        identidade = '$identidade',
                        orgao_emissor_identidade = '$orgaoEmissorIdentidade',
                        estado_identidade = '$estadoIdentidade',
                        $labelDataIdentidade$dataIdentidade
                        titulo_eleitoral = '$tituloEleitoral',
                        zona = '$zona',
                        secao = '$secao',
                        pispasep = '$pispasep',
                        naturalidade = '$naturalidade', 
                        nacionalidade = '$nacionalidade', 
                        nome_pai = '$nomePai', 
                        cpf_pai = '$cpfPai', 
                        nome_mae = '$nomeMae', 
                        cpf_mae = '$cpfMae', 
                        cep = '$cep', 
                        logradouro = '$logradouro', 
                        numero = '$numero', 
                        complemento = '$complemento', 
                        bairro = '$bairro', 
                        cidade = '$cidade', 
                        estado = '$estado', 
                        telefone1 = '$telefone1', 
                        telefone2 = '$telefone2', 
                        email = '$email', 
                        formacao = '$formacao', 
                        ocupacao = '$ocupacao', 
                        canhoto = '$canhoto', 
                        deficiente = '$deficiente'
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
        $query = "DELETE FROM pessoa WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
