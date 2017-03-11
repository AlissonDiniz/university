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
include_once 'MainController.php';
include_once '../../function/FuncoesHTML.php';
include_once '../../function/enum/DiaSemana.php';
include_once '../../function/enum/AulaEnum.php';
include_once '../../function/enum/Turno.php';
include_once '../../function/enum/Formula.php';
include_once '../../function/enum/SituacaoDisciplina.php';
include_once '../../function/enum/Meses.php';
include_once '../../function/enum/Dias.php';
include_once '../../function/enum/FaltaEnum.php';
include_once '../../function/util/Number.php';
include_once '../../function/Enum.php';
include_once '../../function/util/Data.php';
include_once '../class/Nota.php';
include_once '../class/MatriculaTurmaDisciplina.php';
include_once '../class/TurmaDisciplina.php';
include_once '../class/Horario.php';
include_once '../class/Aula.php';
include_once '../class/Falta.php';

class NotaController extends MainController {

    public $params;

    public function _index() {
        $turmaDisciplina = new TurmaDisciplina();
        $data['turmaDisciplina'] = $turmaDisciplina->listar($_SESSION['id']);
        $this->class = array("enum" => new Enum(), "data" => new Data());
        $this->render($this->action, "list", $data);
    }

    public function _show() {
        $turmaDisciplina = new TurmaDisciplina();
        $data = $turmaDisciplina->get($this->params['id']);
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "data" => new Data(), "formula" => new Formula());
        $this->render($this->action, "show", $data);
    }

    public function _avaliacao() {
        $turmaDisciplina = new TurmaDisciplina();
        $data['turmaDisciplina'] = $turmaDisciplina->get($this->params['id']);
        $qtdNotas = substr($data['turmaDisciplina']['dados']['formula'], 0, 1);
        $etapas = array();

        for ($index = 1; $index < ($qtdNotas + 1); $index++) {
            $etapas[] = array("id" => $this->params['id'] . "-" . $index, "nome" => $index . "ª Unidade");
        }
        $etapas[] = array("id" => $this->params['id'] . "-" . "R", "nome" => "Reposicão");
        if (substr($data['turmaDisciplina']['dados']['formula'], 1, 1) == "C") {
            $etapas[] = array("id" => $this->params['id'] . "-" . "F", "nome" => "Prova Final");
        }
        $data['etapas'] = $etapas;
        $this->render($this->action, "avaliacao", $data);
    }

    public function _showAvaliacao() {
        $turmaDisciplina = new TurmaDisciplina();
        $arrayParams = explode("-", $this->params['id']);
        if ($arrayParams[1] == "R") {
            $data['etapa'] = array("id" => $arrayParams[1], "nome" => "Reposição");
        } else if ($arrayParams[1] == "F") {
            $data['etapa'] = array("id" => $arrayParams[1], "nome" => "Prova Final");
        } else {
            $data['etapa'] = array("id" => $arrayParams[1], 'nome' => $arrayParams[1] . "ª Unidade");
        }
        $data['turmaDisciplina'] = $turmaDisciplina->get($arrayParams[0]);
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $nota = new Nota();
        $arrayMatriculaTurmaDisciplina = array();
        foreach ($matriculaTurmaDisciplina->listarToTurmaDisciplina($arrayParams[0]) as $value) {
            $arrayNota = $nota->getToMatriculaTurmaDisciplina($value['dados']['id'], $arrayParams[1]);
            $value['dados']['nota'] = $arrayNota['dados']['valor'];
            $arrayMatriculaTurmaDisciplina[] = $value;
        }
        $data['matriculaTurmaDisciplina'] = $arrayMatriculaTurmaDisciplina;
        $this->class = array("enum" => new Enum(), "data" => new Data(), "number" => new Number());
        $this->render($this->action, "showAvaliacao", $data);
    }

    public function _editAvaliacao() {
        $turmaDisciplina = new TurmaDisciplina();
        $arrayParams = explode("-", $this->params['id']);
        if ($arrayParams[1] == "R") {
            $data['etapa'] = array("id" => $arrayParams[1], "nome" => "Reposição");
        } else if ($arrayParams[1] == "F") {
            $data['etapa'] = array("id" => $arrayParams[1], "nome" => "Prova Final");
        } else {
            $data['etapa'] = array("id" => $arrayParams[1], 'nome' => $arrayParams[1] . "ª Unidade");
        }
        $data['turmaDisciplina'] = $turmaDisciplina->get($arrayParams[0]);
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $nota = new Nota();
        $arrayMatriculaTurmaDisciplina = array();
        foreach ($matriculaTurmaDisciplina->listarToTurmaDisciplina($arrayParams[0]) as $value) {
            $arrayNota = $nota->getToMatriculaTurmaDisciplina($value['dados']['id'], $arrayParams[1]);
            $value['dados']['valorNota'] = $arrayNota['dados']['valor'];
            $value['dados']['idNota'] = $arrayNota['dados']['id'];
            $arrayMatriculaTurmaDisciplina[] = $value;
        }
        $data['matriculaTurmaDisciplina'] = $arrayMatriculaTurmaDisciplina;
        $this->class = array("enum" => new Enum(), "data" => new Data(), "number" => new Number());
        $this->render($this->action, "editAvaliacao", $data);
    }

    public function _UPDATEAVALIACAO() {
        $nota = new Nota();
        foreach ($this->params['nota'] as $key => $value) {
            $arrayKey = explode("-", $key);
            if (!$nota->updateByDiario($arrayKey[0], $arrayKey[1], $arrayKey[2], $value, $this->params['userCreate'])) {
                $_SESSION['error'] = "Ocorreu um erro ao alterar a Avaliação!";
                $this->redirect($this->action, "showAvaliacao", array("id" => $this->params['id']));
                die();
            }
        }
        $_SESSION['flash'] = "Avaliação alterada com Sucesso!";
        $this->redirect($this->action, "showAvaliacao", array("id" => $this->params['id']));
    }

}

?>
