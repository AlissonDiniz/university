<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DiarioController
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
include_once '../class/MatriculaTurmaDisciplina.php';
include_once '../class/TurmaDisciplina.php';
include_once '../class/Horario.php';
include_once '../class/Aula.php';
include_once '../class/Falta.php';

class DiarioController extends MainController {

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

    public function _listAula() {
        $turmaDisciplina = new TurmaDisciplina();
        $data['turmaDisciplina'] = $turmaDisciplina->get($this->params['id']);
        $aula = new Aula();
        $data['aula'] = $aula->listar($this->params['id']);
        $this->class = array("enum" => new Enum(), "data" => new Data(), "diaSemana" => new DiaSemana());
        $this->render($this->action, "listAula", $data);
    }

    public function _createAula() {
        $turmaDisciplina = new TurmaDisciplina();
        $data['turmaDisciplina'] = $turmaDisciplina->get($this->params['id']);
        $horario = new Horario();
        $array = array();
        $enum = new Enum();
        $diaSemana = new DiaSemana();
        foreach ($horario->listar($_SESSION['id'], $this->params['id']) as $value) {
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
        $this->render($this->action, "createAula", $data);
    }

    public function _showAula() {
        $aula = new Aula();
        $falta = new Falta();
        $data['aula'] = $aula->get($this->params['id']);
        $turmaDisciplina = new TurmaDisciplina();
        $data['turmaDisciplina'] = $turmaDisciplina->get($data['aula']['dados']['turmaDisciplina']);
        $data['faltas'] = $falta->listarToAula($this->params['id']);
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "data" => new Data(), "diaSemana" => new DiaSemana(), "faltaEnum" => new FaltaEnum());
        $this->render($this->action, "showAula", $data);
    }

    public function _editAula() {
        $aula = new Aula();
        $falta = new Falta();
        $data['aula'] = $aula->get($this->params['id']);
        $turmaDisciplina = new TurmaDisciplina();
        $data['turmaDisciplina'] = $turmaDisciplina->get($data['aula']['dados']['turmaDisciplina']);
        $data['faltas'] = $falta->listarToAula($this->params['id']);
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "data" => new Data(), "diaSemana" => new DiaSemana());
        $this->render($this->action, "editAula", $data);
    }

    public function _horarios() {
        $horario = new Horario();
        $turmaDisciplina = new TurmaDisciplina();
        $arrayTurmaDisciplina = $turmaDisciplina->get($this->params['d']);
        $data['turmaDisciplina'] = $arrayTurmaDisciplina['dados'];
        $data['horario'] = $horario->listar($_SESSION['id'], $this->params['d']);
        $this->class = array('enum' => new Enum(), 'turno' => new Turno, "diaSemana" => new DiaSemana(), "aulas" => new AulaEnum());
        $this->render($this->action, "horarios", $data);
    }

    public function _alunosMatriculados() {
        $turmaDisciplina = new TurmaDisciplina();
        $data['turmaDisciplina'] = $turmaDisciplina->get($this->params['id']);
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $data['matriculaTurmaDisciplina'] = $matriculaTurmaDisciplina->listarToTurmaDisciplina($this->params['id']);
        $this->class = array("enum" => new Enum(), "data" => new Data(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "alunosMatriculados", $data);
    }

    public function _SAVEAULA() {
        $aula = new Aula();
        $falta = new Falta();
        $arrayHorario = explode("-", $this->params['horario']);
        if ($aula->save($arrayHorario[0], $this->params['conteudo'], $this->params['ano'] . "-" . $this->params['mes'] . "-" . $this->params['dia'] . " " . date("H:i:s"), $this->params['userCreate'])) {
            foreach ($this->params['alunos'] as $idAluno => $value) {
                if (!$falta->save($idAluno, $aula->id, $value, $this->params['qtdAulas'][$idAluno], $this->params['userCreate'])) {
                    $_SESSION['error'] = "Ocorreu um erro ao salvar a Frequência!";
                    $this->redirect($this->action, "listAula", array("id" => $this->params['td']));
                    die();
                }
            }
            $_SESSION['flash'] = "Aula salva com Sucesso!";
            $this->redirect($this->action, "listAula", array("id" => $this->params['td']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar a Aula!";
            $this->redirect($this->action, "createAula", array("id" => $this->params['td']));
        }
    }

    public function _UPDATEAULA() {
        $aula = new Aula();
        $falta = new Falta();
        $data['aula'] = $aula->get($this->params['id']);
        if ($aula->update($this->params)) {
            foreach ($this->params['alunos'] as $idAula => $value) {
                if (!$falta->update($idAula, $value, $this->params['qtdAulas'][$idAula])) {
                    $_SESSION['error'] = "Ocorreu um erro ao alterar a Frequência!";
                    $this->redirect($this->action, "listAula", array("id" => $data['aula']['dados']['turmaDisciplina']));
                    die();
                }
            }
            $_SESSION['flash'] = "Aula alterada com Sucesso!";
            $this->redirect($this->action, "listAula", array("id" => $data['aula']['dados']['turmaDisciplina']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Aula!";
            $this->redirect($this->action, "listAula", array("id" => $data['aula']['dados']['turmaDisciplina']));
        }
    }

    public function _DELETEAULA() {
        $aula = new Aula();
        $data['aula'] = $aula->get($this->params['id']);
        if ($aula->delete($this->params)) {
            $_SESSION['flash'] = "Aula deletada com Sucesso!";
            $this->redirect($this->action, "listAula", array("id" => $data['aula']['dados']['turmaDisciplina']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Aula!";
            $this->redirect($this->action, "listAula", array("id" => $data['aula']['dados']['turmaDisciplina']));
        }
    }

}

?>
