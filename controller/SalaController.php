<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SalaController
 *
 * @author Alisson
 */
include_once '../class/Sala.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';

class SalaController extends MainController {

    public $action;
    public $method;
    public $params;

    public function SalaController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_report", "authority" => 4);
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
        $sala = new Sala();
        $zebraPagination = $this->paginate($sala->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum());
        $data = $sala->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $this->render($this->action, "create", null);
    }

    public function _show() {
        $sala = new Sala();
        $data = $sala->get($this->params['id']);
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $sala = new Sala();
        $data = $sala->get($this->params['id']);
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $this->render($this->action, "search", null);
    }

    public function _report() {
        $this->render($this->action, "report", null);
    }

    public function _SAVE() {
        $sala = new Sala();
        if ($sala->save($this->params)) {
            $_SESSION['flash'] = "Sala salva com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $sala->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar a Sala!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _UPDATE() {
        $sala = new Sala();
        if ($sala->update($this->params)) {
            $_SESSION['flash'] = "Sala alterada com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $sala->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Sala!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $sala = new Sala();
        if ($sala->delete($this->params)) {
            $_SESSION['flash'] = "Sala deletado com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar o Sala!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _result() {
        $conection = new Conection();
        $codigo = $this->params['codigo'];
        $descricao = $this->params['descricao'];
        $this->params['carteiras'] != "" ? $queryCarteira = "carteiras = '" . $this->params['carteiras'] . "'" : $queryCarteira = "carteiras > 0";

        $query = "SELECT * FROM sala 
                    WHERE codigo LIKE '$codigo%' AND
                          descricao LIKE '$descricao%' AND 
                          $queryCarteira";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->render($this->action, "result", $arrayRetorno);
    }

    public function _resultReport() {
        $conection = new Conection();
        $codigo = $this->params['codigo'];
        $descricao = $this->params['descricao'];
        $this->params['carteiras'] != "" ? $queryCarteira = "carteiras = '" . $this->params['carteiras'] . "'" : $queryCarteira = "carteiras > 0";

        $query = "SELECT * FROM sala 
                    WHERE codigo LIKE '$codigo%' AND
                          descricao LIKE '$descricao%' AND 
                          $queryCarteira";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['titulo'] = "Relatório de Salas";
        $data['result'] = $arrayRetorno;
        $this->class = new Enum();
        $this->renderReport($this->action, "result", $data);
    }

}

?>