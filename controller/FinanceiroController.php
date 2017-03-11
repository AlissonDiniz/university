<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FinanceiroController
 *
 * @author Alisson
 */
include_once '../class/Grade.php';
include_once '../class/Turma.php';
include_once '../class/Periodo.php';
include_once '../function/Enum.php';
include_once '../function/util/Number.php';
include_once '../function/util/Data.php';
include_once '../function/enum/Numbers.php';
include_once '../function/enum/SituacaoTitulo.php';
include_once '../function/FuncoesHTML.php';

class FinanceiroController extends MainController {

    public $action;
    public $method;
    public $params;

    public function FinanceiroController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_inadimplencia", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_inadimplenciaIndividual", "authority" => 4);
		$this->authorityMethod[] = array("name" => "_controleFinanceiro", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_resultInadimplencia", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_resultInadimplenciaIndividual", "authority" => 4);
		$this->authorityMethod[] = array("name" => "_resultControleFinanceiro", "authority" => 4);
		$this->authorityMethod[] = array("name" => "_resultControleFinanceiroAluno", "authority" => 4);
    }

    public function _index() {
        $this->_inadimplencia();
    }

    public function _inadimplencia() {
        $grade = new Grade();
        $arrayGrades = $grade->listarGradesAtivas();
        $array = array();
        foreach ($arrayGrades as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['grades'] = $array;
        $periodo = new Periodo();
        $array = array();
        foreach ($periodo->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum(), "numbers" => new Numbers());
        $this->render($this->action, "inadimplencia", $data);
    }
    
    public function _inadimplenciaIndividual() {
        $this->render($this->action, "inadimplenciaIndividual", null);
    }

    public function _controleFinanceiro() {
        $grade = new Grade();
        $arrayGrades = $grade->listarGradesAtivas();
        $array = array();
        foreach ($arrayGrades as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['grades'] = $array;
        $periodo = new Periodo();
        $array = array();
        foreach ($periodo->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum());
        $this->render($this->action, "controleFinanceiro", $data);
    }
	
	public function _controleFinanceiroAluno() {
        $periodo = new Periodo();
        $array = array();
        foreach ($periodo->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum());
        $this->render($this->action, "controleFinanceiroAluno", $data);
    }

    public function _resultInadimplencia() {
        $conection = new Conection();
        $idGrade = $this->params['grade'];
        if ($idGrade != "%") {
            $grade = new Grade();
            $data['grade'] = $grade->get($idGrade);
        } else {
            $data['grade'] = array("dados" => array("codigo" => "", "nome" => "Todas"));
        }
        if (isset($this->params['turma'])) {
            $idTurma = $this->params['turma'];
            if ($idTurma != "%") {
                $turma = new Turma();
                $data["turma"] = $turma->get($idTurma);
            } else {
                $data["turma"] = array("dados" => array("codigo" => "", "observacao" => "Todas"));
            }
        } else {
            $data["turma"] = array("dados" => array("codigo" => "", "observacao" => "Todas"));
            $idTurma = "%";
        }
        $idPeriodo = $this->params['periodo'];
        if ($idPeriodo != "%") {
            $periodo = new Periodo();
            $data['periodo'] = $periodo->get($idPeriodo);
            $queryDataPagamento = "t.vencimento BETWEEN '".str_replace("00:00:00", "", $data['periodo']['dados']['inicio'])."' AND '".str_replace("00:00:00", "", $data['periodo']['dados']['termino'])."' AND ";
        } else {
            $data['periodo'] = array("dados" => array("codigo" => "Todos"));
            $queryDataPagamento = "";
        }
        $parcela = $this->params['parcela'];
        if ($parcela != "%") {
            $data['parcela'] = $parcela;
        } else {
            $data['parcela'] = "Todas";
        }
        $query = "(SELECT t.*, p.nome, p.cpf, a.matricula, pa.numero AS parcela FROM titulo t
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    INNER JOIN grade g ON g.id = a.grade_id
                    WHERE pa.numero LIKE '$parcela' AND 
                          m.turma_id LIKE '$idTurma' AND
                          $queryDataPagamento
                          g.id LIKE '$idGrade')
                  UNION
                  (SELECT t.*, p.nome, p.cpf, a.matricula, '-' AS parcela FROM titulo t
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    WHERE $queryDataPagamento 1=1)";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            if ($array['situacao'] != "B" && $array['status'] == "1" && strtotime(date("Y-m-d")) > strtotime($array['vencimento'])) {
                $array['situacao'] = "V";
                $arrayRetorno[] = array("dados" => $array);
            }
        }
        $data['titulo'] = "Relatório de Inadimplência";
        $data['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "situacaoTitulo" => new SituacaoTitulo(), "number" => new Number(), "data" => new Data());
        $this->renderReport($this->action, "resultInadimplencia", $data);
    }
    
    public function _resultInadimplenciaIndividual() {
        $conection = new Conection();
        $cpf = $this->params['cpf'];
        $matricula = $this->params['matricula'];
        $nome = $this->params['nome'];

        $data['cpf'] = $cpf;
        $data['matricula'] = $matricula;
        $data['nome'] = $nome;
        
        $queryNome = $nome != "" ? "p.nome LIKE '$nome%' OR" : "";
        
        $query = "(SELECT t.*, p.nome, p.cpf, a.matricula, pa.numero AS parcela FROM titulo t
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    INNER JOIN grade g ON g.id = a.grade_id
                    WHERE $queryNome 
                          p.cpf = '$cpf' OR
                          a.matricula = '$matricula')
                  UNION
                  (SELECT t.*, p.nome, p.cpf, a.matricula, '-' AS parcela FROM titulo t
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    WHERE $queryNome  
                          p.cpf = '$cpf' OR
                          a.matricula = '$matricula')";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            if ($array['situacao'] != "B" && $array['status'] == "1" && strtotime(date("Y-m-d")) > strtotime($array['vencimento'])) {
                $array['situacao'] = "V";
                $arrayRetorno[] = array("dados" => $array);
            }
        }
        $data['titulo'] = "Relatório de Inadimplência Individual";
        $data['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "situacaoTitulo" => new SituacaoTitulo(), "number" => new Number(), "data" => new Data());
        $this->renderReport($this->action, "resultInadimplenciaIndividual", $data);
    }

    public function _resultControleFinanceiro() {
        $conection = new Conection();
        $idGrade = $this->params['grade'];
        if ($idGrade != "%") {
            $grade = new Grade();
            $data['grade'] = $grade->get($idGrade);
        } else {
            $data['grade'] = array("dados" => array("codigo" => "", "nome" => "Todas"));
        }
        $idPeriodo = $this->params['periodo'];
        if ($idPeriodo != "%") {
            $periodo = new Periodo();
            $data['periodo'] = $periodo->get($idPeriodo);
            $queryDataPagamento = "t.vencimento BETWEEN '".str_replace("00:00:00", "", $data['periodo']['dados']['inicio'])."' AND '".str_replace("00:00:00", "", $data['periodo']['dados']['termino'])."' AND ";
        } else {
            $data['periodo'] = array("dados" => array("codigo" => "Todos"));
            $queryDataPagamento = "";
        }
        if (isset($this->params['turma'])) {
            $idTurma = $this->params['turma'];
            if ($idTurma != "%") {
                $turma = new Turma();
                $data["turma"] = $turma->get($idTurma);
            } else {
                $data["turma"] = array("dados" => array("codigo" => "", "observacao" => "Todas"));
            }
        } else {
            $data["turma"] = array("dados" => array("codigo" => "", "observacao" => "Todas"));
            $idTurma = "%";
        }
        $query = "(SELECT t.*, p.nome, p.cpf, a.matricula, pa.numero AS parcela, b.data_pagamento AS dataPagamento, fp.descricao AS formaPagamento FROM titulo t
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    INNER JOIN grade g ON g.id = a.grade_id
                    LEFT JOIN baixa b ON b.titulo_id = t.id
                    LEFT JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    WHERE m.turma_id LIKE '$idTurma' AND
                          $queryDataPagamento
                          g.id LIKE '$idGrade')
                  UNION
                  (SELECT t.*, p.nome, p.cpf, a.matricula, '-' AS parcela, b.data_pagamento AS dataPagamento, fp.descricao AS formaPagamento FROM titulo t
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    LEFT JOIN baixa b ON b.titulo_id = t.id
                    LEFT JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    WHERE $queryDataPagamento 1=1)
                ORDER BY vencimento, nome, matricula, parcela";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            if ($array['situacao'] != "B" && $array['status'] == "1" && strtotime(date("Y-m-d")) > strtotime($array['vencimento'])) {
                $array['situacao'] = "V";
            }
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['titulo'] = "Relatório para Controle da Situação Financeira do Aluno";
        $data['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "situacaoTitulo" => new SituacaoTitulo(), "number" => new Number(), "data" => new Data());
        $this->renderReport($this->action, "resultControleFinanceiro", $data);
    }
	
	public function _resultControleFinanceiroAluno() {
        $conection = new Conection();
        $idPeriodo = $this->params['periodo'];
		$nome = $this->params['nome'];
		$matricula = $this->params['matricula'];
        if ($idPeriodo != "%") {
            $periodo = new Periodo();
            $data['periodo'] = $periodo->get($idPeriodo);
            $queryDataPagamento = "t.vencimento BETWEEN '".str_replace("00:00:00", "", $data['periodo']['dados']['inicio'])."' AND '".str_replace("00:00:00", "", $data['periodo']['dados']['termino'])."' AND ";
        } else {
            $data['periodo'] = array("dados" => array("codigo" => "Todos"));
            $queryDataPagamento = "";
        }
		$data['nome'] = $nome;
		$data['matricula'] = $matricula;
		
        $query = "(SELECT t.*, p.nome, p.cpf, a.matricula, pa.numero AS parcela, b.data_pagamento AS dataPagamento, fp.descricao AS formaPagamento FROM titulo t
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    INNER JOIN grade g ON g.id = a.grade_id
                    LEFT JOIN baixa b ON b.titulo_id = t.id
                    LEFT JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    WHERE p.nome LIKE '$nome%' AND a.matricula LIKE '$matricula%' AND $queryDataPagamento 1=1)
                  UNION
                  (SELECT t.*, p.nome, p.cpf, a.matricula, '-' AS parcela, b.data_pagamento AS dataPagamento, fp.descricao AS formaPagamento FROM titulo t
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    LEFT JOIN baixa b ON b.titulo_id = t.id
                    LEFT JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    WHERE p.nome LIKE '$nome%' AND a.matricula LIKE '$matricula%' AND $queryDataPagamento 1=1)
                ORDER BY vencimento, nome, matricula, parcela";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            if ($array['situacao'] != "B" && $array['status'] == "1" && strtotime(date("Y-m-d")) > strtotime($array['vencimento'])) {
                $array['situacao'] = "V";
            }
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['titulo'] = "Relatório para Controle da Situação Financeira do Aluno";
        $data['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "situacaoTitulo" => new SituacaoTitulo(), "number" => new Number(), "data" => new Data());
        $this->renderReport($this->action, "resultControleFinanceiroAluno", $data);
    }

}

?>