<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConfiguracaoController
 *
 * @author Alisson
 */
include_once '../class/Configuracao.php';
include_once '../config/security.php';
include_once '../config/Conection.php';

class ConfiguracaoController extends MainController {

    public $action;
    public $method;
    public $params;

    public function ConfiguracaoController() {
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
        $configuracao = new Configuracao();
        $zebraPagination = $this->paginate($configuracao->count());
        $this->class = array('pagination' => $zebraPagination['pagination']);
        $data = $configuracao->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $this->render($this->action, "create", null);
    }

    public function _show() {
        $configuracao = new Configuracao();
        $data = $configuracao->get($this->params['id']);
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $configuracao = new Configuracao();
        $data = $configuracao->get($this->params['id']);
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $this->render($this->action, "search", null);
    }

    public function _report() {
        $this->render($this->action, "report", null);
    }

    public function _SAVE() {
        $configuracao = new Configuracao();
        if ($configuracao->save($this->params)) {
            $_SESSION['flash'] = "Configuração salva com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $configuracao->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar a Configuração!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _UPDATE() {
        $configuracao = new Configuracao();
        if ($configuracao->update($this->params)) {
            $_SESSION['flash'] = "Configuração alterada com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $configuracao->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Configuração!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $configuracao = new Configuracao();
        if ($configuracao->delete($this->params)) {
            $_SESSION['flash'] = "Configuração deletado com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar o Configuração!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _result() {
        $conection = new Conection();
        $agencia = $this->params['agencia'];
        $conta = $this->params['conta'];
        $query = "SELECT * FROM configuracao 
                    WHERE agencia LIKE '$agencia%' AND
                          conta LIKE '$conta%'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->render($this->action, "result", $arrayRetorno);
    }

}

?>