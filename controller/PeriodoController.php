<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PeriodoController
 *
 * @author Alisson
 */
include_once '../class/Periodo.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/util/Data.php';

class PeriodoController extends MainController {

    public $action;
    public $method;
    public $params;

    public function PeriodoController() {
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
        $periodo = new Periodo();
        $zebraPagination = $this->paginate($periodo->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "data" => new Data());
        $data = $periodo->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $this->render($this->action, "create", null);
    }

    public function _show() {
        $periodo = new Periodo();
        $data = $periodo->get($this->params['id']);
        $this->class = new Data();
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $periodo = new Periodo();
        $data = $periodo->get($this->params['id']);
        $this->class = new Data();
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $this->render($this->action, "search", null);
    }

    public function _SAVE() {
        $periodo = new Periodo();
        $data = new Data();
        $this->params['inicio'] = $data->dataBrasilToDataUSA($this->params['inicio']);
        $this->params['termino'] = $data->dataBrasilToDataUSA($this->params['termino']);
        if ($periodo->save($this->params)) {
            $_SESSION['flash'] = "Período salvo com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $periodo->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar o Período!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _UPDATE() {
        $periodo = new Periodo();
        $data = new Data();
        $this->params['inicio'] = $data->dataBrasilToDataUSA($this->params['inicio']);
        $this->params['termino'] = $data->dataBrasilToDataUSA($this->params['termino']);
        if ($periodo->update($this->params)) {
            $_SESSION['flash'] = "Período alterado com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $periodo->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Período!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $periodo = new Periodo();
        if ($periodo->delete($this->params)) {
            $_SESSION['flash'] = "Período deletado com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar o Período!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _result() {
        $conection = new Conection();
        $codigo = $this->params['codigo'];
        $query = "SELECT * FROM periodo 
                    WHERE codigo LIKE '$codigo%'";
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
