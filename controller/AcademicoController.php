<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AcademicoController
 *
 * @author Alisson
 */
include_once '../class/Grade.php';
include_once '../class/Turma.php';
include_once '../class/Periodo.php';
include_once '../class/Parametro.php';
include_once '../class/Aluno.php';
include_once '../class/Plano.php';
include_once '../class/Titulo.php';
include_once '../class/Parcela.php';
include_once '../class/Matricula.php';
include_once '../class/Modulo.php';
include_once '../class/Pendencia.php';
include_once '../class/MatriculaTurmaDisciplina.php';
include_once '../function/Enum.php';
include_once '../function/enum/ModuloEnum.php';
include_once '../function/FuncoesHTML.php';

class AcademicoController extends MainController {

    public $action;
    public $method;
    public $params;

    public function AcademicoController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_diario", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_rematricular", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_getTurmas", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_getPlano", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_transferir", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_getTurmasTransferir", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_FECHARDIARIO", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_RUNREMATRICULAR", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVETRANSFERIR", "authority" => 4);
    }

    public function _index() {
        $this->_diario();
    }

    public function _diario() {
        $grade = new Grade();
        $arrayGrades = $grade->listarGradesAtivas();
        $array = array();
        foreach ($arrayGrades as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['grades'] = $array;
        $parametro = new Parametro();
        $arrayParametros = $parametro->get();
        $array = array();
        foreach ($arrayParametros as $value) {
            $array[] = array("value" => $value['periodo_matricula_id'], "nome" => $value['periodoMatricula']);
        }
        $data['parametros'] = $array;
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum());
        $this->render($this->action, "diario", $data);
    }

    public function _rematricular() {
        $grade = new Grade();
        $arrayGrades = $grade->listarGradesAtivas();
        $array = array();
        foreach ($arrayGrades as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['grades'] = $array;
        $parametro = new Parametro();
        $arrayParametros = $parametro->get();
        $array = array();
        foreach ($arrayParametros as $value) {
            $array[] = array("value" => $value['periodo_matricula_id'], "nome" => $value['periodoMatricula']);
        }
        $data['parametros'] = $array;
        $periodo = new Periodo();
        $arrayPeriodos = $periodo->listar();
        $array = array();
        foreach ($arrayPeriodos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum());
        $this->render($this->action, "rematricular", $data);
    }

    public function _getTurmas() {
        $turma = new Turma();
        foreach ($turma->getToGrade($this->params['grade'], $this->params['p']) as $turma) {
            echo '<option value="' . $turma['id'] . '">' . $turma['codigo'] . '</option>';
        }
    }

    public function _transferir() {
        $parametro = new Parametro();
        $data['parametros'] = $parametro->get();
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum());
        $this->render($this->action, "transferir", $data);
    }

    public function _getTurmasTransferir() {
        $turma = new Turma();
        foreach ($turma->getTurmasTransferir($this->params['aluno'], $this->params['p']) as $turma) {
            echo '<option value="' . $turma['id'] . '">' . $turma['codigo'] . '</option>';
        }
    }

    public function _getPlano() {
        $plano = new Plano();
        foreach ($plano->getToTurma($this->params['turma'], $this->params['p']) as $plano) {
            echo '<option value="' . $plano['id'] . '">' . $plano['codigo'] . '</option>';
        }
    }

    public function _FECHARDIARIO() {
        $aluno = new Aluno();
        $matricula = new Matricula();
        if (!empty($this->params['turma']) && $this->params['turma'] != "%") {
            foreach ($matricula->listarByTurma($this->params['periodo'], $this->params['turma']) as $value) {
                $this->updateModulo($value['dados']['id'], $value['dados']['grade_id'], $this->params['periodo']);
            }
        } else {
            foreach ($matricula->listarByGrade($this->params['periodo'], $this->params['grade']) as $value) {
                $this->updateModulo($value['dados']['id'], $value['dados']['grade_id'], $this->params['periodo']);
            }
        }
    }

    public function _RUNREMATRICULAR() {
        $aluno = new Aluno();
        $matricula = new Matricula();
        $mensagens = array();
        foreach ($matricula->listarByTurma($this->params['periodoOld'], $this->params['turmaOld']) as $value) {
            foreach ($this->salvarMatricula($value['dados']['id'], $this->params['turmaNew'], $this->params['periodoNew'], $this->params['plano']) as $mensagem) {
                if (!in_array($mensagem, $mensagens)) {
                    $mensagens[] = $mensagem;
                }
            }
        }
        $retorno = " ";
        foreach ($mensagens as $mensagem) {
            $retorno = $retorno . "<br />" . $mensagem;
        }
        $_SESSION['flash'] = $retorno;
        $this->redirect($this->action, "rematricular", null);
    }

    private function salvarMatricula($idAluno, $idTurma, $idPeriodo, $idPlano) {
        $matricula = new Matricula();
        $titulo = new Titulo();
        $mensagens = array();
        if ($matricula->verificaMatriculaAluno($idAluno, $idPeriodo)) {
            $aluno = new Aluno();
            $arrayAluno = $aluno->get($idAluno);
            $pendencia = new Pendencia();
            if ($pendencia->getToPessoaBloqueia($arrayAluno['dados']['pessoa_id'])) {
                $mensagens[] = "A Pessoa informada possui pendência que bloqueia a matricula!";
            } else {
                $params = array();
                $params['aluno'] = $idAluno;
                $params['responsavel'] = $arrayAluno['dados']['responsavel_id'];
                $params['plano'] = $idPlano;
                $params['periodo'] = $idPeriodo;
                $params['turma'] = $idTurma;
                $params['observacao'] = "";
                $params['status'] = "1";
                $params['situacao'] = "ME";
                $params['userCreate'] = $this->params['userCreate'];
                if ($matricula->save($params)) {
                    if ($this->createTitulos($idPlano, $matricula->id)) {
                        $mensagens[] = "Aluno Matriculado com Sucesso!";
                    } else {
                        $mensagens[] = "Ocorreu um erro no título ao matricular o Aluno!";
                    }
                } else {
                    $mensagens[] = "Ocorreu um erro ao matricular o Aluno!";
                }
            }
        } else {
            $mensagens[] = "O Aluno já está matriculado no período!";
        }
        return $mensagens;
    }

    private function createTitulos($idPlano, $idMatricula) {
        $titulo = new Titulo();
        $parcela = new Parcela();
        $plano = new Plano();
        $arrayPlano = $plano->get($idPlano);
        $arrayParcelas = $parcela->listar($idPlano);
        $nossoNumero = $titulo->getMaxNossoNumero();
        if (substr($nossoNumero, 0, 6) < date("Ym")) {
            $nossoNumero = date("Ym") . "00000";
        }
        foreach ($arrayParcelas as $parcela) {
            $nossoNumero = $nossoNumero + 1;
            $params = array("parcela" => $parcela['dados']['id'],
                "matricula" => $idMatricula,
                "configuracao" => $arrayPlano['dados']['configuracao_id'],
                "nossoNumero" => $nossoNumero,
                "vencimento" => $parcela['dados']['data_vencimento'],
                "valor" => $parcela['dados']['valor'],
                "situacao" => "A",
                "status" => 1,
                "linhaDigitavel" => "",
                "observacao" => "",
                "userCreate" => $this->params['userCreate']
            );
            if (!$titulo->save($params)) {
                return false;
                die();
            }
        }
        return true;
    }

    private function updateModulo($idAluno, $idGrade, $idPeriodo) {
        $moduloEnum = new ModuloEnum();
        $arrayModulos = $moduloEnum->loadOpcoes();
        foreach ($arrayModulos as $key => $value) {
            if ($modulo == $value['value']) {
                $modulo = new Modulo();
                $arrayModulo = $modulo->listar($idGrade);
                $maxModulo = "01";
                foreach ($arrayModulo as $value) {
                    if ($maxModulo < $value['dados']['codigo']) {
                        $maxModulo = $value['dados']['codigo'];
                    }
                }
                if ($maxModulo >= $arrayModulos[($key + 1)]['value']) {
                    $aluno = new Aluno();
                    if (!$aluno->updateModulo(array("id" => $idAluno, "modulo" => $arrayModulos[($key + 1)]['value']))) {
                        $_SESSION['error'] = "Ocorreu um erro ao fechar o diário dos Alunos!";
                        $this->redirect($this->action, "diario", null);
                        die();
                    }
                }
            }
        }
        $_SESSION['flash'] = "Diários fechados com Sucesso!";
        $this->redirect($this->action, "diario", null);
    }

    private function updateNotas($idAluno, $idPeriodo) {
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        foreach ($matriculaTurmaDisciplina->listarByAlunoAndPeriodo($idAluno, $idPeriodo) as $value) {
            $turmaDisciplina = new TurmaDisciplina();
            $arrayTurmaDisciplina = $turmaDisciplina->get($value['dados']['turma_disciplina_id']);
            $mediaParcial = 0;
            $mediaFinal = 0;
            $divisor = substr($arrayTurmaDisciplina['dados']['formula'], 0, 1);
            for ($index = 1; $index < ($divisor + 1); $index++) {
                $nota = new Nota();
                $arrayNota = $nota->get($value['dados']['id'], $index);
                if (count($arrayNota['dados']) > 0) {
                    $mediaParcial = $mediaParcial + $arrayNota['dados']['valor'];
                }
            }
        }
    }

    public function _SAVETRANSFERIR() {
        $matricula = new Matricula();
        $arrayMatricula = $matricula->getToAlunoAndPeriodo($this->params['aluno'], $this->params['periodo']);
        if ($matricula->updateTurma($arrayMatricula['dados']['id'], $this->params['turma'])) {
            $_SESSION['flash'] = "Aluno transferido com Sucesso!";
            $this->redirect($this->action, "transferir", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao transferir o Aluno!";
            $this->redirect($this->action, "transferir", null);
        }
    }

}

?>
