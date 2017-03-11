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
include_once 'MainController.php';
include_once '../class/Mensagem.php';
include_once '../../function/FuncoesHTML.php';
include_once '../../function/Enum.php';
include_once '../../function/util/Data.php';
include_once '../../function/enum/MensagemEnum.php';

class MensagemController extends MainController {

    public $params;

    public function _index() {
        $this->_list();
    }

    public function _show() {
        $mensagem = new Mensagem();
        $data = $mensagem->get($this->params['id']);
        $mensagem->updateStatus(array("id" => $this->params['id'], "status" => "1"));
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "data" => new Data(), "mensagemEnum" => new MensagemEnum());
        $this->render($this->action, "show", $data);
    }

    public function _list() {
        $mensagem = new Mensagem();
        $zebraPagination = $this->paginate($mensagem->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum(), "data" => new Data(), "mensagemEnum" => new MensagemEnum());
        $data = $mensagem->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _search() {
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "mensagemEnum" => new MensagemEnum());
        $this->render($this->action, "search", null);
    }

    public function _result() {
        $conection = new Conection();
        $conteudo = $this->params['conteudo'];
        $query = "SELECT * FROM mensagem 
                    WHERE conteudo LIKE '$conteudo%' AND type LIKE 'PROFESSOR'";
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
