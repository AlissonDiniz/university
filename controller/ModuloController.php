<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModuloController
 *
 * @author Alisson
 */

include_once '../class/Modulo.php';
include_once '../class/ModuloDisciplina.php';
include_once '../class/Grade.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/enum/ModuloEnum.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/util/Number.php';

class ModuloController extends MainController {

    public $action;
    public $method;
    public $params;

    public function ModuloController() {
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
        $modulo = new Modulo();
        $grade = new Grade();
        $arrayGrade = $grade->get($this->params['grade']);
        $data['grade'] = $arrayGrade['dados'];
        $data['modulo'] = $modulo->listar($this->params['grade']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $grade = new Grade();
        $data = $grade->get($this->params['grade']);
        $data['grade'] = $data['dados'];
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "modulo" => new ModuloEnum());
        $this->render($this->action, "create", $data);
    }

    public function _show() {
        $modulo = new Modulo();
        $data = $modulo->get($this->params['id']);
        $data['modulo'] = $data['dados'];
        $this->class = array('number' => new Number());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $modulo = new Modulo();
        $data = $modulo->get($this->params['id']);
        $this->render($this->action, "edit", $data);
    }

    public function _SAVE() {
        $modulo = new Modulo();
        if ($modulo->save($this->params)) {
            $_SESSION['flash'] = "Modulo salvo com Sucesso!";
            $this->redirect($this->action, "list", array("id" => "?grade=" . $this->params['grade']));
        } else {
            $data = array("id" => "?grade=" . $this->params['grade']);
            $_SESSION['error'] = "Ocorreu um erro ao salvar o Modulo!";
            $this->redirect($this->action, "create", $data);
        }
    }

    public function _UPDATE() {
        $modulo = new Modulo();
        if ($modulo->update($this->params)) {
            $_SESSION['flash'] = "Modulo alterado com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Modulo!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        }
    }

    public function _DELETE() {
        $modulo = new Modulo();
        $data = $modulo->get($this->params['id']);
        if ($modulo->delete($this->params)) {
            $_SESSION['flash'] = "Modulo deletado com Sucesso!";
            $this->redirect($this->action, "list", array("id" => "?grade=" . $data['dados']['grade_id']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar o Modulo!";
            $this->redirect($this->action, "list", array("id" => "?grade=" . $data['dados']['grade_id']));
        }
    }

}

?>
