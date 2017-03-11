<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FaltaController
 *
 * @author Alisson
 */

include_once '../class/Falta.php';
include_once '../class/MatriculaTurmaDisciplina.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/enum/SituacaoFalta.php';
include_once '../function/enum/DiaSemana.php';
include_once '../function/util/Data.php';

class FaltaController extends MainController {

    public $action;
    public $method;
    public $params;

    public function FaltaController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
    }

    public function _index() {
        $this->_search();
    }

    public function _search() {
        $this->render($this->action, "search", null);
    }

    public function _list() {
        $falta = new Falta();
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $arrayMatriculaTurmaDisciplina = $matriculaTurmaDisciplina->get($this->params['m']);
        $data['matriculaTurmaDisciplina'] = $arrayMatriculaTurmaDisciplina['dados'];
        $data['faltas'] = $falta->listar($this->params['m']);
        $this->class = array('enum' => new Enum(), "data" => new Data(), "situacaoFalta" => new SituacaoFalta(), "diaSemana" => new DiaSemana());
        $this->render($this->action, "list", $data);
    }

    public function _show() {
        $falta = new Falta();
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $data['falta'] = $falta->get($this->params['id']);
        $arrayMatriculaTurmaDisciplina = $matriculaTurmaDisciplina->get($data['falta']['dados']['matricula_turma_disciplina_id']);
        $data['matriculaTurmaDisciplina'] = $arrayMatriculaTurmaDisciplina['dados'];
        $this->class = array('enum' => new Enum(), "data" => new Data(), "situacaoFalta" => new SituacaoFalta(), "diaSemana" => new DiaSemana());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $falta = new Falta();
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $data['falta'] = $falta->get($this->params['id']);
        $arrayMatriculaTurmaDisciplina = $matriculaTurmaDisciplina->get($data['falta']['dados']['matricula_turma_disciplina_id']);
        $data['matriculaTurmaDisciplina'] = $arrayMatriculaTurmaDisciplina['dados'];
        $this->class = array("funcoesHTML" => new FuncoesHTML(), 'enum' => new Enum(), "data" => new Data(), "situacaoFalta" => new SituacaoFalta(), "diaSemana" => new DiaSemana());
        $this->render($this->action, "edit", $data);
    }

    public function _UPDATE() {
        $falta = new Falta();
        $data['falta'] = $falta->get($this->params['id']);
        if ($falta->update($this->params)) {
            $_SESSION['flash'] = "Faltas alteradas com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar as Faltas!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        }
    }

}
?>


