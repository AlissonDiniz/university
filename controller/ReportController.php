<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportController
 *
 * @author Alisson
 */

include_once '../class/Report.php';
include_once '../class/Periodo.php';
include_once '../class/Grade.php';
include_once '../class/Parametro.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/enum/EstadoCivil.php';
include_once '../function/enum/Estado.php';
include_once '../function/FuncoesHTML.php';

class ReportController extends MainController {

    public $action;
    public $method;
    public $params;

    public function ReportController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_result", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_report", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_resultReport", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $report = new Report();
        $this->class = new Enum();
        $data = $report->listar();
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $this->render($this->action, "create", null);
    }

    public function _show() {
        $report = new Report();
        $data = $report->get($this->params['id']);
        $this->class = new Enum();
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $report = new Report();
        $data = $report->get($this->params['id']);
        $this->class = new FuncoesHTML();
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $this->render($this->action, "search", null);
    }

    public function _SAVE() {
        if ($this->isExist($this->params['nome'])) {
            $_SESSION['error'] = "Nome de Relatório já existente!";
            $this->redirect($this->action, "create", null);
        } else {
            $report = new Report();
            if ($report->save($this->params)) {
                $_SESSION['flash'] = "Relatório salvo com Sucesso!";
                $this->redirect($this->action, "show", array("id" => $report->id));
            } else {
                $_SESSION['error'] = "Ocorreu um erro ao salvar o Relatório!";
                $this->redirect($this->action, "create", null);
            }
        }
    }

    public function _UPDATE() {
        $report = new Report();
        if ($report->update($this->params)) {
            $_SESSION['flash'] = "Relatório alterado com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $report->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Relatório!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $report = new Report();
        if ($report->delete($this->params)) {
            $_SESSION['flash'] = "Relatório deletado com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar o Relatório!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        }
    }

    public function isExist($name) {
        $conection = new Conection();
        $query = "SELECT id FROM report 
                    WHERE name = '$name'";
        $result = $conection->selectQuery($query);
        if ($conection->rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function _result() {
        $conection = new Conection();
        $nome = $this->params['nome'];
        $status = $this->params['status'];
        $query = "SELECT * FROM report
                    WHERE name LIKE '$nome%' AND status LIKE '$status'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = new Enum();
        $this->render($this->action, "result", $arrayRetorno);
    }

    public function _report() {
        $periodo = new Periodo();
        $grade = new Grade();
        $arrayGrades = $grade->listarGradesAtivas();
        $arrayPeriodos = $periodo->listar();
        $array = array();
        foreach ($arrayGrades as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['grades'] = $array;
        $array = array();
        foreach ($arrayPeriodos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $parametro = new Parametro();
        $arrayParametros = $parametro->get();
        $array = array();
        foreach ($arrayParametros as $value) {
            $periodoAtual = $value['periodo_atual_id'];
        }
        $data['periodoAtual'] = $periodoAtual;
        $report = new Report();
        $arrayReports = $report->listar();
        $array = array();
        foreach ($arrayReports as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['name']);
        }
        $data['reports'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum());
        $this->render($this->action, "report", $data);
    }

    public function _resultReport() {
        $conection = new Conection();
        $report = new Report();
        $cpf = $this->params['cpf'];
        $matricula = $this->params['matricula'];
        $turma = $this->params['turma'];
        if ($turma == "" && $matricula == "" && $cpf == "") {
            $_SESSION['flash'] = "Preencha o CPF ou a Matricula ou escolha uma Turma!";
            $this->redirect($this->action, "report", null);
        } else {

            if ($matricula == "" && $cpf == "") {
                $query = "SELECT a.matricula, p.*, c.codigo AS codigoCurso, c.nome AS nomeCurso, pe.codigo AS periodo
                        FROM aluno a
                        INNER JOIN pessoa p ON a.pessoa_id = p.id
                        INNER JOIN grade g ON g.id = a.grade_id
                        INNER JOIN curso c ON g.curso_id = c.id
                        INNER JOIN periodo pe ON a.periodo_ingresso_id = pe.id
                        INNER JOIN matricula m ON m.aluno_id = a.id
                        INNER JOIN turma t ON m.turma_id = t.id
                        WHERE t.id = '$turma'";
            } else {
                $query = "SELECT a.matricula, p.*, c.codigo AS codigoCurso, c.nome AS nomeCurso, pe.codigo AS periodo
                        FROM aluno a
                        INNER JOIN pessoa p ON a.pessoa_id = p.id
                        INNER JOIN grade g ON g.id = a.grade_id
                        INNER JOIN curso c ON g.curso_id = c.id
                        INNER JOIN periodo pe ON a.periodo_ingresso_id = pe.id
                        WHERE p.cpf = '$cpf' OR
                              a.matricula = '$matricula'";
            }

            $result = $conection->selectQuery($query);
            $data = array();
            $arrayRetorno = array();
            while ($array = $conection->fetch($result)) {
                $arrayRetorno[] = array("dados" => $array);
            }

            $reportInstance = $report->get($this->params['report']);
            $data['titulo'] = $reportInstance['dados']['titulo'];

            $arrayReport = array();
            foreach ($arrayRetorno as $dataInstance) {
                $reportHTML = $this->createReport($reportInstance['dados']['value'], $dataInstance);
                $arrayReport[] = array("value" => $reportHTML);
            }
            $data['result'] = $arrayReport;
            $this->renderReport($this->action, "result", $data);
        }
    }

    public function createReport($report, $dataInstance) {
        $enum = new Enum();
        $estadoCivil = new EstadoCivil();
        $estado = new Estado();
        $reportHTML = $report;
        $reportHTML = $this->updateHashTag("#{documentNumber}", date("mdHis"), $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentID}", $dataInstance['dados']['matricula'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentName}", $dataInstance['dados']['nome'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentSex}", $dataInstance['dados']['nome'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentCPF}", $dataInstance['dados']['cpf'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentRG}", $dataInstance['dados']['identidade'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentPIS}", $dataInstance['dados']['pispasep'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentORG}", $dataInstance['dados']['orgao_emissor_identidade'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentNationalityCountry}", $dataInstance['dados']['nacionalidade'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentNationalityState}", $dataInstance['dados']['naturalidade'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentMaritalStatus}", $enum->enumOpcoes($dataInstance['dados']['estado_civil'], $estadoCivil->loadOpcoes()), $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentFormation}", $enum->enumOpcoes($dataInstance['dados']['formacao'], $estadoCivil->loadOpcoes()), $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentOccupation}", $enum->enumOpcoes($dataInstance['dados']['ocupacao'], $estadoCivil->loadOpcoes()), $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentStreet}", $dataInstance['dados']['logradouro'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentNumber}", $dataInstance['dados']['numero'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentComplement}", $dataInstance['dados']['complemento'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentNeighborhood}", $dataInstance['dados']['bairro'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentCity}", $dataInstance['dados']['cidade'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentState}", $enum->enumOpcoes($dataInstance['dados']['estado'], $estado->loadEstados()), $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentCEP}", $dataInstance['dados']['cep'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentPhone1}", $dataInstance['dados']['telefone1'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentPhone2}", $dataInstance['dados']['telefone2'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentEmail}", $dataInstance['dados']['email'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentCourseName}", $dataInstance['dados']['nomeCurso'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentCourseCode}", $dataInstance['dados']['codigoCurso'], $reportHTML);
        $reportHTML = $this->updateHashTag("#{studentPeriod}", $dataInstance['dados']['periodo'], $reportHTML);
        return $reportHTML;
    }

    public function updateHashTag($key, $value, $report) {
        return str_replace($key, $value, $report);
    }

}

?>