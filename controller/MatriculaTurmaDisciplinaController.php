<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MatriculaTurmaDisciplinaController
 *
 * @author Alisson
 */

include_once '../class/MatriculaTurmaDisciplina.php';
include_once '../class/Matricula.php';
include_once '../class/Aluno.php';
include_once '../class/TurmaDisciplina.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/enum/DiaSemana.php';
include_once '../function/enum/SituacaoDisciplina.php';
include_once '../function/util/Number.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';

class MatriculaTurmaDisciplinaController extends MainController {

    public $action;
    public $method;
    public $params;

    public function MatriculaTurmaDisciplinaController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_listD", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_createD", "authority" => 4);
        $this->authorityMethod[] = array("name" => "getHorarios", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_getTurmaDisciplina", "authority" => 4);
        $this->authorityMethod[] = array("name" => "getHorariosAjax", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_showD", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVED", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETED", "authority" => 4);
        $this->authorityMethod[] = array("name" => "verificaChoque", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $matricula = new Matricula();
        $arrayMatricula = $matricula->get($this->params['m']);
        $data['matricula'] = $arrayMatricula['dados'];
        $data['matriculaTurmaDisciplina'] = $matriculaTurmaDisciplina->listar($data['matricula']['id']);
        $this->class = array("enum" => new Enum(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "list", $data);
    }

    public function _listD() {
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $matricula = new Matricula();
        $arrayMatricula = $matricula->get($this->params['m']);
        $data['matricula'] = $arrayMatricula['dados'];
        $data['matriculaTurmaDisciplina'] = $matriculaTurmaDisciplina->listarDispensas($data['matricula']['id']);
        $this->class = array("enum" => new Enum(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "listD", $data);
    }

    public function _create() {
        $turmaDisciplina = new TurmaDisciplina();
        $matricula = new Matricula();
        $arrayMatricula = $matricula->get($this->params['m']);
        $data['matricula'] = $arrayMatricula['dados'];
        $array = array();
        $idTurmaDisciplina = "";
        $arrayTurmaDisciplina = $turmaDisciplina->getToTurma($data['matricula']['aluno_id'], $data['matricula']['idTurma']);
        foreach ($arrayTurmaDisciplina as $value) {
            if ($idTurmaDisciplina != $value['dados']['id']) {
                $idTurmaDisciplina = $value['dados']['id'];
                $disciplina = $value['dados']['codDisciplina'] . " - " . $value['dados']['disciplina'];
                $vagas = $value['dados']['vagas'];
                $horario = $this->getHorarios($idTurmaDisciplina, $arrayTurmaDisciplina);
                $array[] = array("id" => $idTurmaDisciplina, "disciplina" => $disciplina, "horario" => $horario, "vagas" => $vagas);
            }
        }
        $data['turmaDisciplina'] = $array;
        $this->class = array("enum" => new Enum(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "create", $data);
    }

    public function _createD() {
        $turmaDisciplina = new TurmaDisciplina();
        $matricula = new Matricula();
        $arrayMatricula = $matricula->get($this->params['m']);
        $data['matricula'] = $arrayMatricula['dados'];
        $array = array();
        $idTurmaDisciplina = "";
        $arrayTurmaDisciplina = $turmaDisciplina->getToTurma($data['matricula']['aluno_id'], $data['matricula']['idTurma']);
        foreach ($arrayTurmaDisciplina as $value) {
            if ($idTurmaDisciplina != $value['dados']['id']) {
                $idTurmaDisciplina = $value['dados']['id'];
                $disciplina = $value['dados']['codDisciplina'] . " - " . $value['dados']['disciplina'];
                $vagas = $value['dados']['vagas'];
                $horario = $this->getHorarios($idTurmaDisciplina, $arrayTurmaDisciplina);
                $array[] = array("id" => $idTurmaDisciplina, "disciplina" => $disciplina, "horario" => $horario, "vagas" => $vagas);
            }
        }
        $data['turmaDisciplina'] = $array;
        $this->class = array("enum" => new Enum(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "createD", $data);
    }

    public function getHorarios($id, $array) {
        $enum = new Enum();
        $diaSemana = new DiaSemana();
        $horarioDia = "";
        $horario = "";
        foreach ($array as $value) {
            if ($value['dados']['id'] == $id) {
                $horarioDia = $horarioDia . "&rAarr; " . $enum->enumOpcoes($value['dados']['dia'], $diaSemana->loadOpcoes()) . "<br />";
                $horario = $horario . $value['dados']['inicio'] . " - " . $value['dados']['termino'] . " - " . $value['dados']['sala'] . "<br />";
            }
        }
        return array("dia" => $horarioDia, "horario" => $horario);
    }

    public function _getTurmaDisciplina() {
        $conection = new Conection();
        if ($this->params['type'] == "cod") {
            $key = "codDisciplina";
            $where = "d.codigo LIKE '" . $this->params['term'] . "%'";
        } else {
            $key = "disciplina";
            $where = "d.nome LIKE '" . $this->params['term'] . "%'";
        }
        $query = "SELECT td.*, t.codigo AS turma, d.codigo AS codDisciplina, d.nome AS disciplina, h.dia, h.inicio, h.termino, s.codigo AS sala FROM turma_disciplina td
                        INNER JOIN turma t ON t.id = td.turma_id
                        INNER JOIN disciplina d ON d.id = td.disciplina_id
                        LEFT JOIN horario h ON td.id = h.turma_disciplina_id
                        LEFT JOIN sala s ON s.id = h.sala_id
                        WHERE " . $where . " AND d.status = '1'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        $idTurmaDisciplina = "";
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $array = array();
        foreach ($arrayRetorno as $value) {
            if ($idTurmaDisciplina != $value['dados']['id']) {
                $idTurmaDisciplina = $value['dados']['id'];
                if ($key == 'disciplina') {
                    $array[] = array("value" => $idTurmaDisciplina, "label" => $value['dados']["codDisciplina"] . " - " . $value['dados'][$key], "cod" => $value['dados']["codDisciplina"], "nome" => $value['dados']['disciplina'], "vagas" => $value['dados']['vagas'], "horario" => $this->getHorariosAjax($idTurmaDisciplina, $arrayRetorno));
                } else {
                    $array[] = array("value" => $idTurmaDisciplina, "label" => $value['dados'][$key], "cod" => $value['dados']["codDisciplina"], "nome" => $value['dados']['disciplina'], "vagas" => $value['dados']['vagas'], "horario" => $this->getHorariosAjax($idTurmaDisciplina, $arrayRetorno));
                }
            }
        }
        echo json_encode($array);
    }

    public function getHorariosAjax($id, $array) {
        $enum = new Enum();
        $diaSemana = new DiaSemana();
        $horario = "";
        foreach ($array as $value) {
            if ($value['dados']['id'] == $id) {
                $horario = $horario . "&rAarr; " . $enum->enumOpcoes($value['dados']['dia'], $diaSemana->loadOpcoes()) . " | " . $value['dados']['inicio'] . " - " . $value['dados']['termino'] . " | " . $value['dados']['sala'] . "<br />";
            }
        }
        return $horario;
    }

    public function _show() {
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $matricula = new Matricula();
        $arrayMatriculaTurmaDisciplina = $matriculaTurmaDisciplina->get($this->params['id']);
        $data['matriculaTurmaDisciplina'] = $arrayMatriculaTurmaDisciplina['dados'];
        $arrayMatricula = $matricula->get($data['matriculaTurmaDisciplina']['matricula_id']);
        $data['matricula'] = $arrayMatricula['dados'];
        $this->class = array("enum" => new Enum(), "situacaoDisciplina" => new SituacaoDisciplina(), "number" => new Number());
        $this->render($this->action, "show", $data);
    }

    public function _showD() {
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $matricula = new Matricula();
        $arrayMatriculaTurmaDisciplina = $matriculaTurmaDisciplina->get($this->params['id']);
        $data['matriculaTurmaDisciplina'] = $arrayMatriculaTurmaDisciplina['dados'];
        $arrayMatricula = $matricula->get($data['matriculaTurmaDisciplina']['matricula_id']);
        $data['matricula'] = $arrayMatricula['dados'];
        $this->class = array("enum" => new Enum(), "situacaoDisciplina" => new SituacaoDisciplina(), "number" => new Number());
        $this->render($this->action, "showD", $data);
    }

    public function _edit() {
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $matricula = new Matricula();
        $arrayMatriculaTurmaDisciplina = $matriculaTurmaDisciplina->get($this->params['id']);
        $data['matriculaTurmaDisciplina'] = $arrayMatriculaTurmaDisciplina['dados'];
        $arrayMatricula = $matricula->get($data['matriculaTurmaDisciplina']['matricula_id']);
        $data['matricula'] = $arrayMatricula['dados'];
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "situacaoDisciplina" => new SituacaoDisciplina(), "number" => new Number());
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $periodo = new Periodo();
        $arrayPeriodos = $periodo->listar();
        $array = array();
        foreach ($arrayPeriodos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "situacaoPeriodo" => new SituacaoPeriodo());
        $this->render($this->action, "search", $data);
    }

    public function _SAVE() {
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $matricula = new Matricula();
        $turmaDisciplina = new TurmaDisciplina();
        $arrayMatricula = $matricula->get($this->params['matricula']);

        foreach ($this->params['turmaDisciplina'] as $value) {
            $this->params['idTurmaDisciplina'] = $value;
            $arrayTurmaDisciplina = $turmaDisciplina->get($value);
            if ($matriculaTurmaDisciplina->verificaDisciplina($arrayMatricula['dados']['aluno_id'], $arrayTurmaDisciplina['dados']['idDisciplina'])) {
                $_SESSION['error'] = "Disciplina já realizada pelo Aluno!";
                $this->redirect($this->action, "list", array("id" => "?m=" . $this->params['matricula']));
                die();
            } else {
                if (!$matriculaTurmaDisciplina->save($this->params)) {
                    $_SESSION['error'] = "Ocorreu um erro ao Matricular a Disciplina no Aluno!";
                    $this->redirect($this->action, "list", array("id" => "?m=" . $this->params['matricula']));
                    die();
                }
            }
        }
        $_SESSION['flash'] = "Disciplinas Matriculadas com Sucesso!";
        $this->redirect($this->action, "list", array("id" => "?m=" . $this->params['matricula']));
    }

    public function _SAVED() {
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $matricula = new Matricula();
        $turmaDisciplina = new TurmaDisciplina();
        $arrayMatricula = $matricula->get($this->params['matricula']);

        foreach ($this->params['turmaDisciplina'] as $value) {
            $this->params['idTurmaDisciplina'] = $value;
            $arrayTurmaDisciplina = $turmaDisciplina->get($value);
            if ($matriculaTurmaDisciplina->verificaDisciplina($$arrayMatricula['dados']['aluno_id'], $arrayTurmaDisciplina['dados']['idDisciplina'])) {
                $_SESSION['error'] = "Disciplina já realizada pelo Aluno!";
                $this->redirect($this->action, "listD", array("id" => "?m=" . $this->params['matricula']));
                die();
            } else {
                if (!$matriculaTurmaDisciplina->saveD($this->params)) {
                    $_SESSION['error'] = "Ocorreu um erro ao Dispensar a Disciplina no Aluno!";
                    $this->redirect($this->action, "listD", array("id" => "?m=" . $this->params['matricula']));
                    die();
                }
            }
        }
        $_SESSION['flash'] = "Disciplinas Dispensadas com Sucesso!";
        $this->redirect($this->action, "listD", array("id" => "?m=" . $this->params['matricula']));
    }

    public function _UPDATE() {
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $arrayMatriculaTurmaDisciplina = $matriculaTurmaDisciplina->get($this->params['id']);
        if ($matriculaTurmaDisciplina->update($this->params)) {
            $_SESSION['flash'] = "Disciplina Matriculada alterada com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $matriculaTurmaDisciplina->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Disciplina Matriculada!";
            $this->redirect($this->action, "list", array("id" => "?m=" . $arrayMatriculaTurmaDisciplina['dados']['matricula_id']));
        }
    }

    public function _DELETE() {
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $arrayMatriculaTurmaDisciplina = $matriculaTurmaDisciplina->get($this->params['id']);
        if ($matriculaTurmaDisciplina->delete($this->params)) {
            $_SESSION['flash'] = "Disciplina Matriculada deletada com Sucesso!";
            $this->redirect($this->action, "list", array("id" => "?m=" . $arrayMatriculaTurmaDisciplina['dados']['matricula_id']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Disciplina Matriculada!";
            $this->redirect($this->action, "list", array("id" => "?m=" . $arrayMatriculaTurmaDisciplina['dados']['matricula_id']));
        }
    }

    public function _DELETED() {
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $arrayMatriculaTurmaDisciplina = $matriculaTurmaDisciplina->get($this->params['id']);
        if ($matriculaTurmaDisciplina->delete($this->params)) {
            $_SESSION['flash'] = "Disciplina Dispensada deletada com Sucesso!";
            $this->redirect($this->action, "listD", array("id" => "?m=" . $arrayMatriculaTurmaDisciplina['dados']['matricula_id']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Disciplina Matriculada!";
            $this->redirect($this->action, "listD", array("id" => "?m=" . $arrayMatriculaTurmaDisciplina['dados']['matricula_id']));
        }
    }

    public function verificaChoque($tipo, $inicioParams, $terminoParams, $inicioValue, $terminoValue) {
        if ($tipo == "0") {
            if ($inicioValue >= $terminoParams || $terminoValue <= $inicioParams) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

}

?>
