<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AulaController
 *
 * @author Alisson
 */
include_once '../class/Aula.php';
include_once '../class/Falta.php';
include_once '../class/TurmaDisciplina.php';
include_once '../class/MatriculaTurmaDisciplina.php';
include_once '../class/Horario.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/enum/Dias.php';
include_once '../function/enum/Meses.php';
include_once '../function/enum/DiaSemana.php';
include_once '../function/enum/AulaEnum.php';
include_once '../function/enum/FaltaEnum.php';
include_once '../function/util/Data.php';

class AulaController extends MainController {

    public $action;
    public $method;
    public $params;

    public function AulaController() {
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
        $turmaDisciplina = new TurmaDisciplina();
        $data['turmaDisciplina'] = $turmaDisciplina->get($this->params['id']);
        $aula = new Aula();
        $data['aula'] = $aula->listar($this->params['id']);
        $this->class = array("enum" => new Enum(), "data" => new Data(), "diaSemana" => new DiaSemana());
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $turmaDisciplina = new TurmaDisciplina();
        $data['turmaDisciplina'] = $turmaDisciplina->get($this->params['id']);
        $horario = new Horario();
        $array = array();
        $enum = new Enum();
        $diaSemana = new DiaSemana();
        foreach ($horario->listar($this->params['id']) as $value) {
            $array[] = array("value" => $value['dados']['id'] . "-" . $value['dados']['aulas'], "nome" => $enum->enumOpcoes($value['dados']['dia'], $diaSemana->loadOpcoes()) . " | " . $value['dados']['inicio'] . " - " . $value['dados']['termino'] . " | " . $value['dados']['sala'] . " | A: " . $value['dados']['aulas'] . "");
        }
        $data['horario'] = $array;
        $array = array();
        $meses = new Meses();
        foreach ($meses->loadOpcoes() as $value) {
            $inicioMes = substr($data['turmaDisciplina']['dados']['inicio'], 5, 2) + 0;
            $terminoMes = substr($data['turmaDisciplina']['dados']['termino'], 5, 2) + 0;
            if ($inicioMes <= ($value['value'] + 0) && $terminoMes >= ($value['value'] + 0)) {
                $array[] = $value;
            }
        }
        $data['ano'] = substr($data['turmaDisciplina']['dados']['termino'], 0, 4);
        $data['meses'] = $array;
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $data['matriculaTurmaDisciplina'] = $matriculaTurmaDisciplina->listarToTurmaDisciplina($this->params['id']);
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => $enum, "dias" => new Dias());
        $this->render($this->action, "create", $data);
    }

    public function _show() {
        $aula = new Aula();
        $falta = new Falta();
        $data['aula'] = $aula->get($this->params['id']);
        $turmaDisciplina = new TurmaDisciplina();
        $data['turmaDisciplina'] = $turmaDisciplina->get($data['aula']['dados']['turmaDisciplina']);
        $data['faltas'] = $falta->listarToAula($this->params['id']);
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "data" => new Data(), "diaSemana" => new DiaSemana(), "faltaEnum" => new FaltaEnum());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $aula = new Aula();
        $falta = new Falta();
        $data['aula'] = $aula->get($this->params['id']);
        $turmaDisciplina = new TurmaDisciplina();
        $data['turmaDisciplina'] = $turmaDisciplina->get($data['aula']['dados']['turmaDisciplina']);
        $data['faltas'] = $falta->listarToAula($this->params['id']);
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "data" => new Data(), "diaSemana" => new DiaSemana());
        $this->render($this->action, "edit", $data);
    }

    public function _SAVE() {
        $aula = new Aula();
        $falta = new Falta();
        $arrayHorario = explode("-", $this->params['horario']);
        if ($aula->save($arrayHorario[0], $this->params['conteudo'], $this->params['ano'] . "-" . $this->params['mes'] . "-" . $this->params['dia'] . " " . date("H:i:s"), $this->params['userCreate'])) {
            foreach ($this->params['alunos'] as $idAluno => $value) {
                if (!$falta->save($idAluno, $aula->id, $value, $this->params['qtdAulas'][$idAluno], $this->params['userCreate'])) {
                    $_SESSION['error'] = "Ocorreu um erro ao salvar a Frequência!";
                    $this->redirect($this->action, "list", array("id" => $this->params['td']));
                    die();
                }
            }
            $_SESSION['flash'] = "Aula salva com Sucesso!";
            $this->redirect($this->action, "list", array("id" => $this->params['td']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar a Aula!";
            $this->redirect($this->action, "create", array("id" => $this->params['td']));
        }
    }

    public function _UPDATE() {
        $aula = new Aula();
        $falta = new Falta();
        $data['aula'] = $aula->get($this->params['id']);
        if ($aula->update($this->params)) {
            foreach ($this->params['alunos'] as $idAula => $value) {
                if (!$falta->update($idAula, $value, $this->params['qtdAulas'][$idAula])) {
                    $_SESSION['error'] = "Ocorreu um erro ao alterar a Frequência!";
                    $this->redirect($this->action, "list", array("id" => $data['aula']['dados']['turmaDisciplina']));
                    die();
                }
            }
            $_SESSION['flash'] = "Aula alterada com Sucesso!";
            $this->redirect($this->action, "list", array("id" => $data['aula']['dados']['turmaDisciplina']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Aula!";
            $this->redirect($this->action, "list", array("id" => $data['aula']['dados']['turmaDisciplina']));
        }
    }

    public function _DELETE() {
        $aula = new Aula();
        $data['aula'] = $aula->get($this->params['id']);
        if ($aula->delete($this->params)) {
            $_SESSION['flash'] = "Aula deletada com Sucesso!";
            $this->redirect($this->action, "list", array("id" => $data['aula']['dados']['turmaDisciplina']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Aula!";
            $this->redirect($this->action, "list", array("id" => $data['aula']['dados']['turmaDisciplina']));
        }
    }

}

?>
