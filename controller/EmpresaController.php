<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmpresaController
 *
 * @author Alisson
 */

include_once '../class/Empresa.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/Enum.php';
include_once '../function/enum/Estado.php';

class EmpresaController extends MainController {

    public $action;
    public $method;
    public $params;

    public function EmpresaController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
    }

    public function _index() {
        $this->_show();
    }

    public function _show() {
        $empresa = new Empresa();
        $data = $empresa->get();
        $this->class = array("funcoesHTML" => new FuncoesHTML(), 'enum' => new Enum(), 'estados' => new Estado());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $empresa = new Empresa();
        $data = $empresa->get();
        $this->class = array("funcoesHTML" => new FuncoesHTML(), 'estados' => new Estado());
        $this->render($this->action, "edit", $data);
    }

    public function _UPDATE() {
        $empresa = new Empresa();
        if ($empresa->update($this->params)) {
            $_SESSION['flash'] = "Empresa alterada com Sucesso!";
            $this->redirect($this->action, "show", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Empresa!";
            $this->redirect($this->action, "edit", null);
        }
    }

}

?>
