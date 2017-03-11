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
include_once '../class/Periodo.php';
include_once '../class/Turma.php';
include_once '../class/TurmaDisciplina.php';
include_once '../class/Horario.php';
include_once '../class/Grade.php';
include_once '../class/Parametro.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/enum/TurmaEnum.php';
include_once '../function/enum/SituacaoDisciplina.php';
include_once '../function/enum/Turno.php';

class DiarioController extends MainController {

    public $action;
    public $method;
    public $params;

    public function DiarioController() {
        $this->authorityMethod[] = array("name" => "_alunos", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_getTurma", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_getTurmaDisciplina", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_getHorario", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_resultReportAlunos", "authority" => 4);
    }

    public function _alunos() {
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
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum());
        $this->render($this->action, "alunos", $data);
    }

    public function _listaPresenca() {
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
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum());
        $this->render($this->action, "listaPresenca", $data);
    }

    public function _getTurma() {
        $turma = new Turma();
        echo '<option value="0">Selecione ...</option>';
        foreach ($turma->getToGrade($this->params['grade'], $this->params['p']) as $turma) {
            echo '<option value="' . $turma['id'] . "-" . $turma['codigo'] . '">' . $turma['codigo'] . '</option>';
        }
    }

    public function _getTurmaDisciplina() {
        $turmaDisciplina = new TurmaDisciplina();
        $arrayTurma = explode("-", $this->params['turma']);
        echo '<option value="0">Selecione ...</option>';
        foreach ($turmaDisciplina->listarByTurma($this->params['turma']) as $value) {
            echo '<option value="' . $value['dados']['id'] . '">' . $value['dados']['codigoDisciplina'] . " - " . $value['dados']['nomeDisciplina'] . '</option>';
        }
    }

    public function _getHorario() {
        $horario = new Horario();
        foreach ($horario->listar($this->params['turmaDisciplina']) as $value) {
            echo '<option value="' . $value['dados']['id'] . '">' . $value['dados']['professor'] . '</option>';
        }
    }

    public function _resultReportAlunos() {
        $conection = new Conection();
        $grade = new Grade();
        $data = array();
        $data['grade'] = $grade->get($this->params['grade']);
        $periodo = new Periodo();
        $data['periodo'] = $periodo->get($this->params['periodo']);
        $turma = $this->params['turma'];
        $turmaDisciplina = new TurmaDisciplina();
        $data['turmaDisciplina'] = $turmaDisciplina->getToDiario($this->params['turmaDisciplina'], $this->params['horario']);
        $query = "SELECT 
                    mtd.situacao,
                    a.matricula,
                    pe.nome
                    FROM matricula_turma_disciplina mtd
                    INNER JOIN matricula m ON m.id = mtd.matricula_id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa pe ON pe.id = a.pessoa_id
                    WHERE mtd.turma_disciplina_id = '" . $data['turmaDisciplina']['dados']['id'] . "'
                    ORDER BY pe.nome";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['turma'] = $turma;
        $data['titulo'] = "Relatório - Diário - Alunos Matriculados";
        $data['result'] = $arrayRetorno;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "situacao" => new SituacaoDisciplina());
        $this->renderReport($this->action, "resultAlunos", $data);
    }

    public function _resultReportListaPresenca() {
        $conection = new Conection();
        $grade = new Grade();
        $data = array();
        $data['grade'] = $grade->get($this->params['grade']);
        $periodo = new Periodo();
        $data['periodo'] = $periodo->get($this->params['periodo']);
        $turma = $this->params['turma'];
        $turmaDisciplina = new TurmaDisciplina();
        $data['turmaDisciplina'] = $turmaDisciplina->getToDiario($this->params['turmaDisciplina'], $this->params['horario']);
        $query = "SELECT 
                    mtd.situacao,
                    a.matricula,
                    pe.nome
                    FROM matricula_turma_disciplina mtd
                    INNER JOIN matricula m ON m.id = mtd.matricula_id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa pe ON pe.id = a.pessoa_id
                    WHERE mtd.turma_disciplina_id = '" . $data['turmaDisciplina']['dados']['id'] . "'
                    ORDER BY pe.nome";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['turma'] = $turma;
        $data['titulo'] = "Relatório - Diário - Lista de Presença";
        $data['result'] = $arrayRetorno;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "situacao" => new SituacaoDisciplina());
        $this->renderReport($this->action, "resultListaPresenca", $data);
    }

}

?>
