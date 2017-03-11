<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TurmaDisciplinaController
 *
 * @author Alisson
 */
include_once '../class/Turma.php';
include_once '../class/TurmaDisciplina.php';
include_once '../class/MatriculaTurmaDisciplina.php';
include_once '../class/Modulo.php';
include_once '../class/Nota.php';
include_once '../class/Parametro.php';
include_once '../class/Periodo.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/util/Number.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/enum/Formula.php';
include_once '../function/enum/SituacaoDisciplina.php';
include_once '../function/util/Data.php';

class TurmaDisciplinaController extends MainController {

    public $action;
    public $method;
    public $params;

    public function TurmaDisciplinaController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_diario", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_alunosMatriculados", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_avaliacao", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_showAvaliacao", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_editAvaliacao", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_listByTurma", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_showByTurma", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_showD", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_editByTurma", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_searchD", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATEBYTURMA", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATEAVALIACAO", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETEBYTURMA", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_result", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_resultD", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $turmaDisciplina = new TurmaDisciplina();
        $zebraPagination = $this->paginate($turmaDisciplina->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum(), "data" => new Data());
        $data = $turmaDisciplina->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _diario() {
        $turmaDisciplina = new TurmaDisciplina();
        $zebraPagination = $this->paginate($turmaDisciplina->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum(), "data" => new Data());
        $data = $turmaDisciplina->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "diario", $data);
    }

    public function _alunosMatriculados() {
        $turmaDisciplina = new TurmaDisciplina();
        $data['turmaDisciplina'] = $turmaDisciplina->get($this->params['id']);
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $data['matriculaTurmaDisciplina'] = $matriculaTurmaDisciplina->listarToTurmaDisciplina($this->params['id']);
        $this->class = array("enum" => new Enum(), "data" => new Data(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "alunosMatriculados", $data);
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

    public function _listByTurma() {
        $turmaDisciplina = new TurmaDisciplina();
        $turma = new Turma();
        $arrayTurma = $turma->get($this->params['turma']);
        $data['turma'] = $arrayTurma['dados'];
        $data['turmaDisciplina'] = $turmaDisciplina->listar($this->params['turma']);
        $this->class = array("enum" => new Enum(), "data" => new Data());
        $this->render($this->action, "listByTurma", $data);
    }

    public function _create() {
        $modulo = new Modulo();
        $turma = new Turma();
        $parametro = new Parametro();
        $periodo = new Periodo();
        $arrayTurma = $turma->get($this->params['turma']);
        $data['turma'] = $arrayTurma['dados'];
        $arrayDisciplinas = $modulo->listarDisciplinasDoModulo($this->params['turma'], $arrayTurma['dados']['grade_id'], substr($arrayTurma['dados']['codigo'], 5, 2));
        $array = array();
        foreach ($arrayDisciplinas as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['disciplinas'] = $array;
        $arrayParametros = $parametro->get();
        $array = array();
        foreach ($arrayParametros as $value) {
            $data['periodoAtual'] = $value['periodo_atual_id'];
        }
        $arrayPeriodo = $periodo->get($data['periodoAtual']);
        $data['periodo'] = $arrayPeriodo['dados'];
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "data" => new Data(), "formula" => new Formula());
        $this->render($this->action, "create", $data);
    }

    public function _showByTurma() {
        $turmaDisciplina = new TurmaDisciplina();
        $turma = new Turma();
        $arrayTurmaDisciplina = $turmaDisciplina->get($this->params['id']);
        $data['turmaDisciplina'] = $arrayTurmaDisciplina['dados'];
        $arrayTurma = $turma->get($data['turmaDisciplina']['turma_id']);
        $data['turma'] = $arrayTurma['dados'];
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "data" => new Data(), "formula" => new Formula());
        $this->render($this->action, "showByTurma", $data);
    }

    public function _show() {
        $turmaDisciplina = new TurmaDisciplina();
        $data = $turmaDisciplina->get($this->params['id']);
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "data" => new Data(), "formula" => new Formula());
        $this->render($this->action, "show", $data);
    }

    public function _showD() {
        $turmaDisciplina = new TurmaDisciplina();
        $data = $turmaDisciplina->get($this->params['id']);
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "data" => new Data(), "formula" => new Formula());
        $this->render($this->action, "showD", $data);
    }

    public function _editByTurma() {
        $turmaDisciplina = new TurmaDisciplina();
        $turma = new Turma();
        $arrayTurmaDisciplina = $turmaDisciplina->get($this->params['id']);
        $data['turmaDisciplina'] = $arrayTurmaDisciplina['dados'];
        $arrayTurma = $turma->get($data['turmaDisciplina']['turma_id']);
        $data['turma'] = $arrayTurma['dados'];
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "data" => new Data(), "formula" => new Formula());
        $this->render($this->action, "editByTurma", $data);
    }

    public function _edit() {
        $turmaDisciplina = new TurmaDisciplina();
        $turma = new Turma();
        $arrayTurmaDisciplina = $turmaDisciplina->get($this->params['id']);
        $data['turmaDisciplina'] = $arrayTurmaDisciplina['dados'];
        $arrayTurma = $turma->get($data['turmaDisciplina']['turma_id']);
        $data['turma'] = $arrayTurma['dados'];
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "data" => new Data(), "formula" => new Formula());
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $periodo = new Periodo();
        $arrayPeriodo = $periodo->listar();
        $array = array();
        foreach ($arrayPeriodo as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML());
        $this->render($this->action, "search", $data);
    }

    public function _searchD() {
        $periodo = new Periodo();
        $arrayPeriodo = $periodo->listar();
        $array = array();
        foreach ($arrayPeriodo as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML());
        $this->render($this->action, "searchD", $data);
    }

    public function _SAVE() {
        $turmaDisciplina = new TurmaDisciplina();
        $data = new Data();
        $this->params['inicio'] = $data->dataBrasilToDataUSA($this->params['inicio']);
        $this->params['termino'] = $data->dataBrasilToDataUSA($this->params['termino']);
        if ($turmaDisciplina->save($this->params)) {
            $_SESSION['flash'] = "Turma Disciplina salva com Sucesso!";
            $this->redirect($this->action, "listByTurma", array("id" => "?turma=" . $this->params['turma']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar a Turma Disciplina!";
            $this->redirect($this->action, "create", array("id" => "?turma=" . $this->params['turma']));
        }
    }

    public function _UPDATE() {
        $turmaDisciplina = new TurmaDisciplina();
        $data = new Data();
        $this->params['inicio'] = $data->dataBrasilToDataUSA($this->params['inicio']);
        $this->params['termino'] = $data->dataBrasilToDataUSA($this->params['termino']);
        if ($turmaDisciplina->update($this->params)) {
            $_SESSION['flash'] = "Turma Disciplina alterada com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $turmaDisciplina->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Turma Disciplina!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _UPDATEBYTURMA() {
        $turmaDisciplina = new TurmaDisciplina();
        $data = new Data();
        $this->params['inicio'] = $data->dataBrasilToDataUSA($this->params['inicio']);
        $this->params['termino'] = $data->dataBrasilToDataUSA($this->params['termino']);
        if ($turmaDisciplina->update($this->params)) {
            $_SESSION['flash'] = "Turma Disciplina alterada com Sucesso!";
            $this->redirect($this->action, "listByTurma", array("id" => "?turma=" . $this->params['turma']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Turma Disciplina!";
            $this->redirect($this->action, "listByTurma", array("id" => "?turma=" . $this->params['turma']));
        }
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

    public function _DELETE() {
        $turmaDisciplina = new TurmaDisciplina();
        if ($turmaDisciplina->delete($this->params)) {
            $_SESSION['flash'] = "Turma Disciplina deletada com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Turma Disciplina!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETEBYTURMA() {
        $turmaDisciplina = new TurmaDisciplina();
        if ($turmaDisciplina->delete($this->params)) {
            $_SESSION['flash'] = "Turma Disciplina deletada com Sucesso!";
            $this->redirect($this->action, "listByTurma", array("id" => "?turma=" . $this->params['turma']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Turma Disciplina!";
            $this->redirect($this->action, "listByTurma", array("id" => "?turma=" . $this->params['turma']));
        }
    }

    public function _result() {
        $conection = new Conection();
        $codigoTurma = $this->params['codigoTurma'];
        $codigoDisciplina = $this->params['codigoDisciplina'];
        $nomeDisciplina = $this->params['nomeDisciplina'];
        $periodo = $this->params['periodo'];
        $status = $this->params['status'];
        $query = "SELECT td.*, d.codigo AS codDisciplina, d.nome AS disciplina FROM turma_disciplina td
                    INNER JOIN turma t ON t.id = td.turma_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    WHERE t.codigo LIKE '$codigoTurma%' AND
                          d.codigo LIKE '$codigoDisciplina%' AND
                          d.nome LIKE '$nomeDisciplina%' AND
                          t.periodo_id LIKE '$periodo%' AND
                          td.status LIKE '$status'
                    ORDER BY td.data DESC";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['turmaDisciplina'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "data" => new Data());
        $this->render($this->action, "result", $data);
    }

    public function _resultD() {
        $conection = new Conection();
        $codigoTurma = $this->params['codigoTurma'];
        $codigoDisciplina = $this->params['codigoDisciplina'];
        $nomeDisciplina = $this->params['nomeDisciplina'];
        $periodo = $this->params['periodo'];
        $status = $this->params['status'];
        $query = "SELECT td.*, d.codigo AS codDisciplina, d.nome AS disciplina FROM turma_disciplina td
                    INNER JOIN turma t ON t.id = td.turma_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    WHERE t.codigo LIKE '$codigoTurma%' AND
                          d.codigo LIKE '$codigoDisciplina%' AND
                          d.nome LIKE '$nomeDisciplina%' AND
                          t.periodo_id LIKE '$periodo%' AND
                          td.status LIKE '$status'
                    ORDER BY td.data DESC";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['turmaDisciplina'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "data" => new Data());
        $this->render($this->action, "resultD", $data);
    }

}

?>
