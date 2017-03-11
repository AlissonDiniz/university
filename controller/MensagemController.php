<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MensagemController
 *
 * @author Alisson
 */
include_once '../class/Mensagem.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/enum/MensagemEnum.php';
include_once '../function/util/Data.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';

class MensagemController extends MainController {

    public $action;
    public $method;
    public $params;

    public function MensagemController() {
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
        $mensagem = new Mensagem();
        $zebraPagination = $this->paginate($mensagem->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum(), "data" => new Data(), "mensagemEnum" => new MensagemEnum());
        $data = $mensagem->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "mensagemEnum" => new MensagemEnum());
        $this->render($this->action, "create", null);
    }

    public function _show() {
        $mensagem = new Mensagem();
        $data = $mensagem->get($this->params['id']);
        $this->class = array("enum" => new Enum(), "data" => new Data(), "mensagemEnum" => new MensagemEnum());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $mensagem = new Mensagem();
        $data = $mensagem->get($this->params['id']);
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "mensagemEnum" => new MensagemEnum());
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "mensagemEnum" => new MensagemEnum());
        $this->render($this->action, "search", null);
    }

    public function _report() {
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "mensagemEnum" => new MensagemEnum());
        $this->render($this->action, "report", null);
    }

    public function _SAVE() {
        $mensagem = new Mensagem();
        if ($mensagem->save($this->params)) {
            $_SESSION['flash'] = "Mensagem salva com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $mensagem->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar a Mensagem!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _UPDATE() {
        $mensagem = new Mensagem();
        if ($mensagem->update($this->params)) {
            $_SESSION['flash'] = "Mensagem alterada com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $mensagem->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Mensagem!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $mensagem = new Mensagem();
        if ($mensagem->delete($this->params)) {
            $_SESSION['flash'] = "Mensagem deletada com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Mensagem!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _result() {
        $conection = new Conection();
        $conteudo = $this->params['conteudo'];
        $type = $this->params['type'];
        $query = "SELECT * FROM mensagem 
                    WHERE conteudo LIKE '$conteudo%' AND type LIKE '$type%'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = array("enum" => new Enum(), "data" => new Data(), "mensagemEnum" => new MensagemEnum());
        $this->render($this->action, "result", $arrayRetorno);
    }

}

?>