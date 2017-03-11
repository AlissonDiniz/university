<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormaPagamentoController
 *
 * @author Alisson
 */
include_once '../class/FormaPagamento.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/util/Data.php';

class FormaPagamentoController extends MainController {

    public $action;
    public $method;
    public $params;

    public function FormaPagamentoController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $formaPagamento = new FormaPagamento();
        $zebraPagination = $this->paginate($formaPagamento->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "data" => new Data());
        $data = $formaPagamento->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $this->render($this->action, "create", null);
    }

    public function _show() {
        $formaPagamento = new FormaPagamento();
        $data = $formaPagamento->get($this->params['id']);
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $formaPagamento = new FormaPagamento();
        $data = $formaPagamento->get($this->params['id']);
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $this->render($this->action, "search", null);
    }

    public function _report() {
        $this->render($this->action, "report", null);
    }

    public function _SAVE() {
        $formaPagamento = new FormaPagamento();
        if ($formaPagamento->save($this->params)) {
            $_SESSION['flash'] = "Forma de Pagamento salva com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $formaPagamento->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar a Forma de Pagamento!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _UPDATE() {
        $formaPagamento = new FormaPagamento();
        if ($formaPagamento->update($this->params)) {
            $_SESSION['flash'] = "Forma de Pagamento alterada com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $formaPagamento->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Forma de Pagamento!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $formaPagamento = new FormaPagamento();
        if ($formaPagamento->delete($this->params)) {
            $_SESSION['flash'] = "Forma de Pagamento deletada com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Forma de Pagamento!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _result() {
        $conection = new Conection();
        $descricao = $this->params['descricao'];
        $query = "SELECT * FROM forma_pagamento 
                    WHERE descricao LIKE '$descricao%'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = new Data();
        $this->render($this->action, "result", $arrayRetorno);
    }

}

?>