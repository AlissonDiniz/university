<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ParametroController
 *
 * @author Alisson
 */

include_once '../class/Periodo.php';
include_once '../class/Parametro.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/util/Number.php';

class ParametroController extends MainController {

    public $action;
    public $method;
    public $params;

    public function ParametroController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
    }

    public function _index() {
        $this->_show();
    }

    public function _show() {
        $parametro = new Parametro();
        $data = $parametro->get();
        $this->class = array("number" => new Number);
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $parametro = new Parametro();
        $periodo = new Periodo();
        $arrayPeriodos = $periodo->listar();
        $array = array();
        foreach ($arrayPeriodos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $data['parametros'] = $parametro->get();
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "number" => new Number());
        $this->render($this->action, "edit", $data);
    }

    public function _UPDATE() {
        $parametro = new Parametro();
        if ($parametro->update($this->params)) {
            $_SESSION['flash'] = "Parametros alterados com Sucesso!";
            $this->redirect($this->action, "show", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar os Parametros!";
            $this->redirect($this->action, "edit", null);
        }
    }

}

?>
