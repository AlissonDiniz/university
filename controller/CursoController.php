<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CursoController
 *
 * @author Alisson
 */
include_once '../class/Curso.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';

class CursoController extends MainController {

    public $action;
    public $method;
    public $params;

    public function CursoController() {
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
        $curso = new Curso();
        $zebraPagination = $this->paginate($curso->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum());
        $data = $curso->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $this->render($this->action, "create", null);
    }

    public function _show() {
        $curso = new Curso();
        $data = $curso->get($this->params['id']);
        $this->class = new Enum();
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $curso = new Curso();
        $data = $curso->get($this->params['id']);
        $this->class = new FuncoesHTML();
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $this->render($this->action, "search", null);
    }

    public function _report() {
        $this->render($this->action, "report", null);
    }

    public function _SAVE() {
        $curso = new Curso();
        if ($curso->save($this->params)) {
            $_SESSION['flash'] = "Curso salvo com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $curso->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar o Curso!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _UPDATE() {
        $curso = new Curso();
        if ($curso->update($this->params)) {
            $_SESSION['flash'] = "Curso alterado com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $curso->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Curso!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $curso = new Curso();
        if ($curso->delete($this->params)) {
            $_SESSION['flash'] = "Curso deletado com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar o Curso!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _result() {
        $conection = new Conection();
        $codigo = $this->params['codigo'];
        $nome = $this->params['nome'];
        $status = $this->params['status'];
        $query = "SELECT * FROM curso 
                    WHERE codigo LIKE '$codigo%' AND
                          nome LIKE '$nome%' AND 
                          status LIKE '$status'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = new Enum();
        $this->render($this->action, "result", $arrayRetorno);
    }

    public function _resultReport() {
        $conection = new Conection();
        $codigo = $this->params['codigo'];
        $nome = $this->params['nome'];
        $status = $this->params['status'];
        $query = "SELECT * FROM curso 
                    WHERE codigo LIKE '$codigo%' AND
                          nome LIKE '$nome%' AND 
                          status LIKE '$status'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['titulo'] = "Relatório de Cursos";
        $data['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum());
        $this->renderReport($this->action, "result", $data);
    }

}

?>
