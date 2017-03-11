<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoDescontoController
 *
 * @author Alisson
 */
include_once '../class/TipoDesconto.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/enum/DescontoEnum.php';
include_once '../function/util/Data.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';

class TipoDescontoController extends MainController {

    public $action;
    public $method;
    public $params;

    public function TipoDescontoController() {
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
        $tipoDesconto = new TipoDesconto();
        $zebraPagination = $this->paginate($tipoDesconto->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum(), "data" => new Data(), "descontoEnum" => new DescontoEnum());
        $data = $tipoDesconto->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "descontoEnum" => new DescontoEnum());
        $this->render($this->action, "create", null);
    }

    public function _show() {
        $tipoDesconto = new TipoDesconto();
        $data = $tipoDesconto->get($this->params['id']);
        $this->class = array("enum" => new Enum(), "data" => new Data(), "descontoEnum" => new DescontoEnum());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $tipoDesconto = new TipoDesconto();
        $data = $tipoDesconto->get($this->params['id']);
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "descontoEnum" => new DescontoEnum());
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "descontoEnum" => new DescontoEnum());
        $this->render($this->action, "search", null);
    }

    public function _report() {
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "descontoEnum" => new DescontoEnum());
        $this->render($this->action, "report", null);
    }

    public function _SAVE() {
        $tipoDesconto = new TipoDesconto();
        if ($tipoDesconto->save($this->params)) {
            $_SESSION['flash'] = "Tipo de Desconto salvo com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $tipoDesconto->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar o Tipo de Desconto!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _UPDATE() {
        $tipoDesconto = new TipoDesconto();
        if ($tipoDesconto->update($this->params)) {
            $_SESSION['flash'] = "Tipo de Desconto alterado com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $tipoDesconto->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Tipo de Desconto!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $tipoDesconto = new TipoDesconto();
        if ($tipoDesconto->delete($this->params)) {
            $_SESSION['flash'] = "Tipo de Desconto deletado com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar o Tipo de Desconto!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _result() {
        $conection = new Conection();
        $descricao = $this->params['descricao'];
        $type = $this->params['type'];
        $query = "SELECT * FROM tipo_desconto 
                    WHERE descricao LIKE '$descricao%' AND type LIKE '$type%'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = array("enum" => new Enum(), "data" => new Data(), "descontoEnum" => new DescontoEnum());
        $this->render($this->action, "result", $arrayRetorno);
    }

}

?>