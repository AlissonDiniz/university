<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfessorController
 *
 * @author Alisson
 */
include_once '../class/Professor.php';
include_once '../class/Pessoa.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/util/String.php';

class ProfessorController extends MainController {

    public $action;
    public $method;
    public $params;

    public function ProfessorController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_report", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_searchProfessor", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_result", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_resultReport", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $professor = new Professor();
        $zebraPagination = $this->paginate($professor->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum());
        $data = $professor->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum());
        $this->render($this->action, "create", null);
    }

    public function _show() {
        $professor = new Professor();
        $data = $professor->get($this->params['id']);
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $professor = new Professor();
        $data = $professor->get($this->params['id']);
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum());
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $this->render($this->action, "search", null);
    }

    public function _report() {
        $this->render($this->action, "report", null);
    }

    public function _searchProfessor() {
        $conection = new Conection();
        if ($this->params['type'] == "cpf") {
            $key = "cpf";
            $where = "pe.cpf LIKE '" . $this->params['term'] . "%'";
        } else {
            $key = "nome";
            $where = "pe.nome LIKE '" . $this->params['term'] . "%'";
        }

        $query = "SELECT p.id, pe.cpf, pe.nome FROM professor p
                        INNER JOIN pessoa pe ON pe.id = p.pessoa_id
                        WHERE " . $where . " AND p.status = '1'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("value" => $array['id'], "label" => $array[$key], "cpf" => $array["cpf"], "nome" => $array['nome']);
        }
        echo json_encode($arrayRetorno);
    }

    public function _SAVE() {
        $professor = new Professor();
        $pessoa = new Pessoa();
        $string = new String();
        $arrayPessoa = $pessoa->get($this->params['pessoa']);
        $this->params['username'] = $professor->createUsername($string->lowercase($arrayPessoa['dados']['nome']));
        $this->params['password'] = str_replace("-", "", str_replace(".", "", $arrayPessoa['dados']['cpf']));
        if ($professor->save($this->params)) {
            $_SESSION['flash'] = "Professor salvo com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $professor->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar o Professor!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _UPDATE() {
        $professor = new Professor();
        if ($professor->update($this->params)) {
            $_SESSION['flash'] = "Professor alterado com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $professor->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Professor!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $professor = new Professor();
        if ($professor->delete($this->params)) {
            $_SESSION['flash'] = "Professor deletado com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar o Professor!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        }
    }

    public function _result() {
        $conection = new Conection();
        $cpf = $this->params['cpf'];
        $nome = $this->params['nome'];
        $query = "SELECT pro.*, p.nome, p.cpf FROM professor pro
                    INNER JOIN pessoa p ON pro.pessoa_id = p.id
                    WHERE p.cpf LIKE '$cpf%' AND
                          p.nome LIKE '$nome%'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = new Enum();
        $this->render($this->action, "result", $arrayRetorno);
    }

    public function _resultReport() {
        $conection = new Conection();
        $cpf = $this->params['cpf'];
        $nome = $this->params['nome'];
        $query = "SELECT 
                    p.nome, 
                    p.cpf, 
                    p.email, 
                    p.telefone1, 
                    p.telefone2,
                    p.cep,
                    p.logradouro, 
                    p.numero,
                    p.complemento,
                    p.bairro,
                    p.cidade, 
                    p.estado
                    FROM professor pro
                    INNER JOIN pessoa p ON pro.pessoa_id = p.id
                    WHERE p.cpf LIKE '$cpf%' AND
                          p.nome LIKE '$nome%'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['titulo'] = "Relatório de Professores";
        $data['result'] = $arrayRetorno;
        $this->class = new Enum();
        $this->renderReport($this->action, "result", $data);
    }

}

?>