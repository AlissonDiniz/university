<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModuloDisciplinaController
 *
 * @author Alisson
 */

include_once '../class/Modulo.php';
include_once '../class/ModuloDisciplina.php';
include_once '../class/Disciplina.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/util/Number.php';

class ModuloDisciplinaController extends MainController {

    public $action;
    public $method;
    public $params;

    public function ModuloDisciplinaController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "getDisciplinas", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $modulo = new Modulo();
        $moduloDisciplina = new ModuloDisciplina();
        $data = $modulo->get($this->params['modulo']);
        $data['modulo'] = $data['dados'];
        $data['moduloDisciplina'] = $moduloDisciplina->listar($this->params['modulo']);
        $this->class = array('number' => new Number(), 'enum' => new Enum());
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $modulo = new Modulo();
        $data = $modulo->get($this->params['modulo']);
        $data['modulo'] = $data['dados'];
        $this->class = array('number' => new Number(), 'enum' => new Enum());
        $this->render($this->action, "create", $data);
    }

    public function _search() {
        $conection = new Conection();
        if ($this->params['type'] == "cod") {
            $where = "codigo LIKE '" . $this->params['term'] . "%'";
        } else {
            $where = "nome LIKE '" . $this->params['term'] . "%'";
        }

        $query = "SELECT id, codigo, nome FROM disciplina WHERE " . $where . " AND status = '1'";
        ;
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        if ($this->params['type'] == "cod") {
            while ($array = $conection->fetch($result)) {
                $arrayRetorno[] = array("value" => $array['id'], "label" => $array["codigo"], "codigo" => $array["codigo"], "nome" => $array['nome']);
            }
        } else {
            while ($array = $conection->fetch($result)) {
                $arrayRetorno[] = array("value" => $array['id'], "label" => $array["codigo"] . " - " . $array['nome'], "codigo" => $array["codigo"], "nome" => $array['nome']);
            }
        }
        echo json_encode($arrayRetorno);
    }

    public function _show() {
        $moduloDisciplina = new ModuloDisciplina();
        $data = $moduloDisciplina->get($this->params['id']);
        $data['moduloDisciplina'] = $data['dados'];
        $this->class = array('enum' => new Enum());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $moduloDisciplina = new ModuloDisciplina();
        $data = $moduloDisciplina->get($this->params['id']);
        $this->class = array('functionHTML' => new FuncoesHTML());
        $this->render($this->action, "edit", $data);
    }

    public function _SAVE() {
        $moduloDisciplina = new ModuloDisciplina();
        if ($moduloDisciplina->save($this->params)) {
            $_SESSION['flash'] = "Disciplina Adicionada com Sucesso!";
            $this->redirect($this->action, "list", array("id" => "?modulo=" . $this->params['modulo']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao adicionar a Disciplina!";
            $this->redirect($this->action, "list", array("id" => "?modulo=" . $this->params['modulo']));
        }
    }

    public function _UPDATE() {
        $moduloDisciplina = new ModuloDisciplina();
        if ($moduloDisciplina->update($this->params)) {
            $_SESSION['flash'] = "Disciplina no Módulo alterada com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Disciplina no Modulo!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        }
    }

    public function _DELETE() {
        $moduloDisciplina = new ModuloDisciplina();
        $data = $moduloDisciplina->get($this->params['id']);
        if ($moduloDisciplina->delete($this->params)) {
            $_SESSION['flash'] = "Disciplina no Modulo deletada com Sucesso!";
            $this->redirect($this->action, "list", array("id" => "?modulo=" . $data['dados']['modulo_id']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Disciplina no Modulo!";
            $this->redirect($this->action, "list", array("id" => "?modulo=" . $data['dados']['modulo_id']));
        }
    }

    public function getDisciplinas($id) {
        $conection = new Conection();
        $query = "SELECT d.*, md.* FROM modulo m
                    INNER JOIN modulo_disciplina md ON md.modulo_id = m.id
                    INNER JOIN disciplina d ON d.id = md.disciplina_id
                    WHERE m.id = '$id'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

}

?>
