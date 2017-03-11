<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ObservacaoController
 *
 * @author Alisson
 */
include_once '../class/Observacao.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/enum/Origem.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';

class ObservacaoController extends MainController {

    public $action;
    public $method;
    public $params;

    public function ObservacaoController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_result", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $observacao = new Observacao();
        $zebraPagination = $this->paginate($observacao->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], 'funcoesHTML' => new FuncoesHTML(), 'enum' => new Enum(), 'origem' => new Origem());
        $data = $observacao->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $this->class = array('funcoesHTML' => new FuncoesHTML(), 'origem' => new Origem());
        $this->render($this->action, "create", null);
    }

    public function _show() {
        $observacao = new Observacao();
        $data = $observacao->get($this->params['id']);
        $this->class = array('funcoesHTML' => new FuncoesHTML(), 'enum' => new Enum(), 'origem' => new Origem());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $observacao = new Observacao();
        $data = $observacao->get($this->params['id']);
        $this->class = array('funcoesHTML' => new FuncoesHTML(), 'enum' => new Enum(), 'origem' => new Origem());
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $this->class = array('funcoesHTML' => new FuncoesHTML(), 'origem' => new Origem());
        $this->render($this->action, "search", null);
    }

    public function _SAVE() {
        $observacao = new Observacao();
        if ($observacao->save($this->params)) {
            $_SESSION['flash'] = "Observação salva com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $observacao->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar a Observação!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _UPDATE() {
        $observacao = new Observacao();
        if ($observacao->update($this->params)) {
            $_SESSION['flash'] = "Observação alterado com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $observacao->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Observação!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $observacao = new Observacao();
        if ($observacao->delete($this->params)) {
            $_SESSION['flash'] = "Observação deletada com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Observação!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _result() {
        $conection = new Conection();
        $cpf = $this->params['cpf'];
        $nome = $this->params['nome'];
        $origem = $this->params['origem'];
        $status = $this->params['status'];
        $query = "SELECT pe.*, p.nome, p.cpf FROM observacao pe
                    INNER JOIN pessoa p on pe.pessoa_id = p.id 
                    WHERE p.cpf LIKE '$cpf%' AND
                          p.nome LIKE '$nome%' AND 
                          pe.origem LIKE '$origem%' AND 
                          pe.status LIKE '$status'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = array('funcoesHTML' => new FuncoesHTML(), 'enum' => new Enum(), 'origem' => new Origem());
        $this->render($this->action, "result", $arrayRetorno);
    }

}

?>
