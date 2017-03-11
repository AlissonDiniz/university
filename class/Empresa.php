<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Empresa
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class Empresa {

    public $id;

    public function get() {
        $conection = new Conection();
        $query = "SELECT * FROM empresa
                    LIMIT 1";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $cnpj = $params['cnpj'];
        $nome = $params['nome'];
        $razao = $params['razao'];
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
        $empresa = $this->get();
        if ($empresa['dados']['id'] != "") {
            $query = "UPDATE empresa 
                        SET nome = '$nome',
                            cnpj = '$cnpj',
                            razao = '$razao', 
                            cep = '$cep', 
                            logradouro = '$logradouro', 
                            numero = '$numero', 
                            complemento = '$complemento', 
                            bairro = '$bairro', 
                            cidade = '$cidade', 
                            estado = '$estado', 
                            telefone1 = '$telefone1', 
                            telefone2 = '$telefone2', 
                            email = '$email'";
        } else {
            $query = "INSERT INTO empresa 
                        (cnpj, nome, razao, cep, logradouro, numero, complemento, bairro,
                            cidade, estado, telefone1, telefone2, email, data, user_create)
                      VALUES
                      ('$cnpj', '$nome', '$razao', '$cep', '$logradouro', '$numero', '$complemento',
                       '$bairro', '$cidade', '$estado', '$telefone1', '$telefone2', '$email', NOW(), '$userCreate')";
        }
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
