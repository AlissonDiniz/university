<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EquivalenciaDisciplinaController
 *
 * @author Alisson
 */

include_once '../class/Aluno.php';
include_once '../class/Disciplina.php';
include_once '../class/EquivalenciaDisciplina.php';
include_once '../class/MatriculaTurmaDisciplina.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/enum/SituacaoDisciplina.php';

class EquivalenciaDisciplinaController extends MainController {

    public $action;
    public $method;
    public $params;

    public function EquivalenciaDisciplinaController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
    }

    public function _index() {
        $this->_search();
    }

    public function _search() {
        $this->render($this->action, "search", null);
    }

    public function _list() {
        $aluno = new Aluno();
        $data['aluno'] = $aluno->get($this->params['aluno']);
        $equivalenciaDisciplina = new EquivalenciaDisciplina();
        $data['equivalenciaDisciplina'] = $equivalenciaDisciplina->listar($this->params['aluno']);
        $this->class = array("enum" => new Enum(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "list", $data);
    }

    public function _show() {
        $equivalenciaDisciplina = new EquivalenciaDisciplina();
        $data['equivalenciaDisciplina'] = $equivalenciaDisciplina->get($this->params['id']);
        $this->class = array("enum" => new Enum(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "show", $data);
    }

    public function _create() {
        $aluno = new Aluno();
        $data['aluno'] = $aluno->get($this->params['aluno']);
        $disciplina = new Disciplina();
        $array = array();
        foreach ($disciplina->listarByGrade($data['aluno']['dados']['grade_id']) as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['disciplina'] = $array;
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $array = array();
        foreach ($matriculaTurmaDisciplina->listarByAluno($data['aluno']['dados']['id']) as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['disciplinaEQ'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum());
        $this->render($this->action, "create", $data);
    }

    public function _SAVE() {
        $equivalenciaDisciplina = new EquivalenciaDisciplina();
        if ($equivalenciaDisciplina->save($this->params)) {
            $_SESSION['flash'] = "Equivalência salva com Sucesso!";
            $this->redirect($this->action, "list", array("id" => "?aluno=" . $this->params['aluno']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar a Equivalência!";
            $this->redirect($this->action, "create", array("id" => "?aluno=" . $this->params['aluno']));
        }
    }

    public function _DELETE() {
        $equivalenciaDisciplina = new EquivalenciaDisciplina();
        if ($equivalenciaDisciplina->delete($this->params)) {
            $_SESSION['flash'] = "Equivalência deletada com Sucesso!";
            $this->redirect($this->action, "list", array("id" => "?aluno=" . $this->params['aluno']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Equivalência!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        }
    }

}

?>
