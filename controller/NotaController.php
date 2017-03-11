<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotaController
 *
 * @author Alisson
 */

include_once '../class/Nota.php';
include_once '../class/Matricula.php';
include_once '../class/MatriculaTurmaDisciplina.php';
include_once '../class/TurmaDisciplina.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/enum/SituacaoDisciplina.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/util/Data.php';
include_once '../function/util/Number.php';

class NotaController extends MainController {

    public $action;
    public $method;
    public $params;

    public function NotaController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "getNotas", "authority" => 4);
        $this->authorityMethod[] = array("name" => "getNotasEdit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_getMatriculas", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
    }

    public function _index() {
        $this->_search();
    }

    public function _search() {
        $this->render($this->action, "search", null);
    }

    public function _list() {
        $matricula = new Matricula();
        $arrayMatricula = $matricula->get($this->params['matricula']);
        $data['matricula'] = $arrayMatricula['dados'];
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $turmaDisciplina = new TurmaDisciplina();
        $array = array();
        foreach ($matriculaTurmaDisciplina->listar($data['matricula']['id']) as $value) {
            $arrayTurmaDisciplina = $turmaDisciplina->get($value['dados']['turma_disciplina_id']);
            $value['dados']['notas'] = $this->getNotas($arrayTurmaDisciplina, $value['dados']['id']);
            $array[] = array("dados" => $value['dados']);
        }
        $data['matriculaTurmaDisciplina'] = $array;
        $this->class = array('enum' => new Enum(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "list", $data);
    }

    public function _show() {
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $arrayMatriculaTurmaDisciplina = $matriculaTurmaDisciplina->get($this->params['id']);
        $data['matriculaTurmaDisciplina'] = $arrayMatriculaTurmaDisciplina['dados'];
        $matricula = new Matricula();
        $arrayMatricula = $matricula->get($data['matriculaTurmaDisciplina']['matricula_id']);
        $data['matricula'] = $arrayMatricula['dados'];
        $turmaDisciplina = new TurmaDisciplina();
        $arrayTurmaDisciplina = $turmaDisciplina->get($data['matriculaTurmaDisciplina']['turma_disciplina_id']);
        $data['matriculaTurmaDisciplina']['notas'] = $this->getNotas($arrayTurmaDisciplina, $data['matriculaTurmaDisciplina']['id']);
        $this->class = array('enum' => new Enum(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $arrayMatriculaTurmaDisciplina = $matriculaTurmaDisciplina->get($this->params['id']);
        $data['matriculaTurmaDisciplina'] = $arrayMatriculaTurmaDisciplina['dados'];
        $matricula = new Matricula();
        $arrayMatricula = $matricula->get($data['matriculaTurmaDisciplina']['matricula_id']);
        $data['matricula'] = $arrayMatricula['dados'];
        $turmaDisciplina = new TurmaDisciplina();
        $arrayTurmaDisciplina = $turmaDisciplina->get($data['matriculaTurmaDisciplina']['turma_disciplina_id']);
        $data['matriculaTurmaDisciplina']['notas'] = $this->getNotasEdit($arrayTurmaDisciplina, $data['matriculaTurmaDisciplina']['id']);
        $this->class = array('number' => new Number(), 'enum' => new Enum(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "edit", $data);
    }

    public function getNotas($turmaDisciplina, $matriculaTurmaDisciplina) {
        $nota = new Nota();
        $number = new Number();
        $qtdNotas = substr($turmaDisciplina['dados']['formula'], 0, 1);
        $retornoNotas = "";
        for ($index = 1; $index < ($qtdNotas + 1); $index++) {
            $arrayNota = $nota->getToMatriculaTurmaDisciplina($matriculaTurmaDisciplina, $index);
            $retornoNotas = $retornoNotas . "Nota " . $index . ": - <strong>" . $number->formatNota($arrayNota['dados']['valor']) . "</strong><br />";
        }

        $arrayNota = $nota->getToMatriculaTurmaDisciplina($matriculaTurmaDisciplina, "R");
        $retornoNotas = $retornoNotas . "Nota " . "R:" . " - <strong>" . $number->formatNota($arrayNota['dados']['valor']) . "</strong><br />";

        if (substr($turmaDisciplina['dados']['formula'], 1, 1) == "C") {
            $arrayNota = $nota->getToMatriculaTurmaDisciplina($matriculaTurmaDisciplina, "F");
            $retornoNotas = $retornoNotas . "Nota " . "F:" . " - " . $number->formatNota($arrayNota['dados']['valor']);
        }
        return $retornoNotas;
    }

    public function getNotasEdit($turmaDisciplina, $matriculaTurmaDisciplina) {
        $nota = new Nota();
        $number = new Number();
        $qtdNotas = substr($turmaDisciplina['dados']['formula'], 0, 1);
        $retornoNotas = array();
        for ($index = 1; $index < ($qtdNotas + 1); $index++) {
            $arrayNota = $nota->getToMatriculaTurmaDisciplina($matriculaTurmaDisciplina, $index);
            $retornoNotas[] = array("numeroEtapa" => $index, "label" => $index . "ª", "valor" => $number->formatNota($arrayNota['dados']['valor']));
        }

        $arrayNota = $nota->getToMatriculaTurmaDisciplina($matriculaTurmaDisciplina, "R");
        $retornoNotas[] = array("numeroEtapa" => "R", "label" => "Reposição", "valor" => $number->formatNota($arrayNota['dados']['valor']));

        if (substr($turmaDisciplina['dados']['formula'], 1, 1) == "C") {
            $arrayNota = $nota->getToMatriculaTurmaDisciplina($matriculaTurmaDisciplina, "F");
            $retornoNotas[] = array("numeroEtapa" => "F", "label" => "Final", "valor" => $number->formatNota($arrayNota['dados']['valor']));
        }
        return $retornoNotas;
    }

    public function _getMatriculas() {
        $matricula = new Matricula();
        foreach ($matricula->getToAluno($this->params['aluno']) as $value) {
            echo '<option value="' . $value['dados']['id'] . '">' . $value['dados']['periodo'] . '</option>';
        }
    }

    public function _UPDATE() {
        $nota = new Nota();
        foreach ($this->params['notas'] as $line => $value) {
            if (!$nota->update($this->params['id'], $line, $value, $this->params['userCreate'])) {
                $_SESSION['error'] = "Ocorreu um erro ao salvar a Nota!";
                $this->redirect($this->action, "show", array("id" => $this->params['id']));
                die();
            }
        }
        $_SESSION['flash'] = "Notas salvas com Sucesso!";
        $this->redirect($this->action, "show", array("id" => $this->params['id']));
    }

}
?>

