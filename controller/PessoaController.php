<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PessoaController
 *
 * @author Alisson
 */

include_once '../class/Pessoa.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/util/Data.php';
include_once '../function/enum/Estado.php';
include_once '../function/enum/EstadoCivil.php';
include_once '../function/enum/Deficiencia.php';

class PessoaController extends MainController {

    public $action;
    public $method;
    public $params;

    public function PessoaController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_searchPessoa", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_getPessoa", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_result", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $pessoa = new Pessoa();
        $zebraPagination = $this->paginate($pessoa->count());
        $data = $pessoa->listar($zebraPagination['limit']);
        $this->class = array('pagination' => $zebraPagination['pagination']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $this->class = array('funcoesHTML' => new FuncoesHTML(), 'estados' => new Estado(), "estadoCivil" => new EstadoCivil(), "deficiencia" => new Deficiencia());
        $this->render($this->action, "create", null);
    }

    public function _show() {
        $pessoa = new Pessoa();
        $this->class = array('enum' => new Enum(), 'funcoesHTML' => new FuncoesHTML(), 'estados' => new Estado(), "estadoCivil" => new EstadoCivil(), "deficiencia" => new Deficiencia(), 'data' => new Data());
        $data = $pessoa->get($this->params['id']);
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $pessoa = new Pessoa();
        $data = $pessoa->get($this->params['id']);
        $this->class = array('enum' => new Enum(), 'funcoesHTML' => new FuncoesHTML(), 'estados' => new Estado(), "estadoCivil" => new EstadoCivil(), "deficiencia" => new Deficiencia(), 'data' => new Data());
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $this->render($this->action, "search", null);
    }

    public function _searchPessoa() {
        $conection = new Conection();
        if ($this->params['type'] == "cpf") {
            $key = "cpf";
            $where = "cpf LIKE '" . urldecode($this->params['term']) . "%'";
        } else {
            $key = "nome";
            $where = "nome LIKE '" . urldecode($this->params['term']) . "%'";
        }

        $query = "SELECT id, cpf, nome FROM pessoa WHERE " . $where;
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("value" => $array['id'], "label" => $array[$key], "cpf" => $array["cpf"], "nome" => $array['nome']);
        }
        echo json_encode($arrayRetorno);
    }

    public function _getPessoa() {
        $pessoa = new Pessoa();
        $data = $pessoa->getByCPF($this->params['cpf']);
        if (count($data['dados']) > 0) {
            $this->redirect("aluno", "create", array("id" => "?pessoa=null"));
        } else {
            $data = $this->params;
            $this->class = array('funcoesHTML' => new FuncoesHTML(), 'estados' => new Estado());
            $this->render($this->action, "create", $data);
        }
    }

    public function _SAVE() {
        $pessoa = new Pessoa();
        $data = new Data();
        $this->params['cpf'] = str_replace("@", "", $this->params['cpf']) . str_replace("@", "", $this->params['cnpj']);
        $this->params['dataNascimento'] = $data->dataBrasilToDataUSA($this->params['dataNascimento']);
        if ($this->params['dataIdentidade'] != "") {
            $this->params['dataIdentidade'] = $data->dataBrasilToDataUSA($this->params['dataIdentidade']);
        }
        if ($pessoa->validateCPF($this->params['cpf'])) {
            if ($pessoa->save($this->params)) {
                $_SESSION['flash'] = "Pessoa salva com Sucesso!";
                $this->redirect($this->action, "show", array("id" => $pessoa->id));
            } else {
                $_SESSION['error'] = "Ocorreu um erro ao salvar a Pessoa!";
                $this->redirect($this->action, "create", null);
            }
        } else {
            $_SESSION['error'] = "Já existem uma pessoa com o CPF informado!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _UPDATE() {
        $pessoa = new Pessoa();
        $data = new Data();
        if ($this->params['dataNascimento'] != "") {
            $this->params['dataNascimento'] = $data->dataBrasilToDataUSA($this->params['dataNascimento']);
        }
        if ($this->params['dataIdentidade'] != "") {
            $this->params['dataIdentidade'] = $data->dataBrasilToDataUSA($this->params['dataIdentidade']);
        }
        if ($pessoa->update($this->params)) {
            $_SESSION['flash'] = "Pessoa alterada com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $pessoa->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Pessoa!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $pessoa = new Pessoa();
        if ($pessoa->delete($this->params)) {
            $_SESSION['flash'] = "Pessoa deletada com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Pessoa!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _result() {
        $conection = new Conection();
        $cpf = $this->params['cpf'];
        $nome = $this->params['nome'];
        $naturalidade = $this->params['naturalidade'];
        $nomePai = $this->params['nomePai'];
        $nomeMae = $this->params['nomeMae'];
        $logradouro = $this->params['logradouro'];
        $telefone = $this->params['telefone'];
        $email = $this->params['email'];
        $query = "SELECT * FROM pessoa 
                    WHERE cpf LIKE '$cpf%' AND
                          nome LIKE '$nome%' AND
                          naturalidade LIKE '$naturalidade%' AND
                          nome_pai LIKE '$nomePai%' AND
                          nome_mae LIKE '$nomeMae%' AND
                          logradouro LIKE '$logradouro%' AND
                          (telefone1 LIKE '$telefone%' OR telefone2 LIKE '$telefone%') AND
                          email LIKE '$email%'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = new Enum();
        $this->render($this->action, "result", $arrayRetorno);
    }

}

?>