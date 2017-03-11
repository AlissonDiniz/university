<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlunoController
 *
 * @author Alisson
 */
include_once '../class/Aluno.php';
include_once '../class/Grade.php';
include_once '../class/Pessoa.php';
include_once '../class/Parametro.php';
include_once '../class/Periodo.php';
include_once '../class/Pendencia.php';
include_once '../class/Observacao.php';
include_once '../class/Titulo.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/enum/Origem.php';
include_once '../function/enum/Turno.php';
include_once '../function/enum/FormaDeIngresso.php';
include_once '../function/enum/SituacaoAluno.php';
include_once '../function/enum/SituacaoDisciplina.php';
include_once '../function/enum/SituacaoPeriodo.php';
include_once '../function/enum/ModuloEnum.php';
include_once '../function/util/Number.php';
include_once '../function/util/Data.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';

class AlunoController extends MainController {

    public $action;
    public $method;
    public $params;

    public function AlunoController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_atividade", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_report", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_reportHistorico", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_reportRDM", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_searchAluno", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATEATIVIDADE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_result", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_resultReport", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_resultReportHistorico", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_resultReportRDM", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $aluno = new Aluno();
        $zebraPagination = $this->paginate($aluno->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum());
        $data = $aluno->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $grade = new Grade();
        $parametro = new Parametro();
        $arrayGrades = $grade->listarGradesAtivas();
        $array = array();
        foreach ($arrayGrades as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['grades'] = $array;
        $arrayParametros = $parametro->get();
        $array = array();
        foreach ($arrayParametros as $value) {
            $array[] = array("value" => $value['periodo_matricula_id'], "nome" => $value['periodoMatricula']);
        }
        $data['parametros'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "formaIngresso" => new FormaDeIngresso(), "turnos" => new Turno());
        $this->render($this->action, "create", $data);
    }

    public function _show() {
        $aluno = new Aluno();
        $pessoa = new Pessoa();
        $data = $aluno->get($this->params['id']);
        $arrayPessoa = $pessoa->get($data['dados']['responsavel_id']);
        $data['dados']['cpfResponsavel'] = $arrayPessoa['dados']['cpf'];
        $data['dados']['nomeResponsavel'] = $arrayPessoa['dados']['nome'];
        $grade = new Grade();
        $arrayGrade = $grade->get($data['dados']['grade_id']);
        $data['dados']['grade'] = $arrayGrade['dados']['codigo'] . " - " . $arrayGrade['dados']['nome'];
        $periodo = new Periodo();
        $arrayPeriodo = $periodo->get($data['dados']['periodo_ingresso_id']);
        $data['dados']['periodoIngresso'] = $arrayPeriodo['dados']['codigo'];
        $pendencia = new Pendencia();
        $arrayPendencia = $pendencia->getToPessoa($data['dados']['pessoa_id']);
        $array = array();
        $enum = new Enum();
        $origem = new Origem();
        foreach ($arrayPendencia as $value) {
            $array[] = array("origem" => $enum->enumOpcoes($value['dados']['origem'], $origem->loadOpcoes()), "descricao" => $value['dados']['descricao']);
        }
        $data['pendencias'] = $array;
        
        $observacao = new Observacao();
        $arrayObservacao = $observacao->getToPessoa($data['dados']['pessoa_id']);
        $array = array();
        foreach ($arrayObservacao as $value) {
            $array[] = array("origem" => $enum->enumOpcoes($value['dados']['origem'], $origem->loadOpcoes()), "descricao" => $value['dados']['descricao']);
        }
        $data['observacoes'] = $array;
        
        $dataUtil = new Data();
        $titulo = new Titulo();
        foreach ($titulo->listarByAluno($this->params['id']) as $titulo) {
            if ($titulo['dados']['situacao'] != "B" && $titulo['dados']['status'] == "1" && strtotime(date("Y-m-d")) > strtotime($titulo['dados']['vencimento'])) {
                $data['pendencias'][] = array("origem" => "Financeiro", "descricao" => "Parcela Vencida ".$dataUtil->dataUSAToDataBrasil($titulo['dados']['vencimento']));
            }
        }
        
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "formaIngresso" => new FormaDeIngresso(), "turnos" => new Turno(), "situacaoAluno" => new SituacaoAluno());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $aluno = new Aluno();
        $pessoa = new Pessoa();
        $data = $aluno->get($this->params['id']);
        $arrayPessoa = $pessoa->get($data['dados']['responsavel_id']);
        $data['dados']['cpfResponsavel'] = $arrayPessoa['dados']['cpf'];
        $data['dados']['nomeResponsavel'] = $arrayPessoa['dados']['nome'];
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "formaIngresso" => new FormaDeIngresso(), "turno" => new Turno(), "modulo" => new ModuloEnum(), "situacaoAluno" => new SituacaoAluno());
        $this->render($this->action, "edit", $data);
    }

    public function _atividade() {
        $aluno = new Aluno();
        $pessoa = new Pessoa();
        $data = $aluno->get($this->params['id']);
        $arrayPessoa = $pessoa->get($data['dados']['responsavel_id']);
        $data['dados']['cpfResponsavel'] = $arrayPessoa['dados']['cpf'];
        $data['dados']['nomeResponsavel'] = $arrayPessoa['dados']['nome'];
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "formaIngresso" => new FormaDeIngresso(), "turno" => new Turno(), "modulo" => new ModuloEnum(), "situacaoAluno" => new SituacaoAluno());
        $this->render($this->action, "atividade", $data);
    }

    public function _search() {
        $grade = new Grade();
        $periodo = new Periodo();
        $arrayGrades = $grade->listar();
        $array = array();
        foreach ($arrayGrades as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['grades'] = $array;
        $arrayPeriodos = $periodo->listar();
        $array = array();
        foreach ($arrayPeriodos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "formaIngresso" => new FormaDeIngresso(), "turnos" => new Turno());
        $this->render($this->action, "search", $data);
    }

    public function _report() {
        $grade = new Grade();
        $periodo = new Periodo();
        $arrayGrades = $grade->listar();
        $array = array();
        foreach ($arrayGrades as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['grades'] = $array;
        $arrayPeriodos = $periodo->listar();
        $array = array();
        foreach ($arrayPeriodos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "formaIngresso" => new FormaDeIngresso(), "turnos" => new Turno());
        $this->render($this->action, "report", $data);
    }

    public function _reportHistorico() {
        $grade = new Grade();
        $periodo = new Periodo();
        $arrayGrades = $grade->listar();
        $array = array();
        foreach ($arrayGrades as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['grades'] = $array;
        $arrayPeriodos = $periodo->listar();
        $array = array();
        foreach ($arrayPeriodos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "formaIngresso" => new FormaDeIngresso(), "turnos" => new Turno());
        $this->render($this->action, "reportHistorico", $data);
    }

    public function _reportRDM() {
        $grade = new Grade();
        $periodo = new Periodo();
        $parametro = new Parametro();
        $arrayParametros = $parametro->get();
        $array = array();
        foreach ($arrayParametros as $value) {
            $periodoMatriculaId = $value['periodo_matricula_id'];
        }
        $data['periodo_matricula_id'] = $periodoMatriculaId;
        $arrayGrades = $grade->listar();
        $array = array();
        foreach ($arrayGrades as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['grades'] = $array;
        $arrayPeriodos = $periodo->listar();
        $array = array();
        foreach ($arrayPeriodos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "formaIngresso" => new FormaDeIngresso(), "turnos" => new Turno());
        $this->render($this->action, "reportRDM", $data);
    }

    public function _searchAluno() {
        $conection = new Conection();
        if ($this->params['type'] == "cpf") {
            $key = "cpf";
            $where = "pe.cpf LIKE '" . urldecode($this->params['term']) . "%'";
        } else {
            $key = "nome";
            $where = "pe.nome LIKE '" . urldecode($this->params['term']) . "%'";
        }

        $query = "SELECT a.id, a.matricula, pe.cpf, pe.nome FROM aluno a
                        INNER JOIN pessoa pe ON pe.id = a.pessoa_id
                        WHERE " . $where . " AND a.status = '1' AND situacao = 'ME'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("value" => $array['id'], "label" => $array["matricula"] . " - " . $array[$key], "matricula" => $array["matricula"], "cpf" => $array["cpf"], "nome" => $array['nome']);
        }
        echo json_encode($arrayRetorno);
    }

    public function _SAVE() {
        if ($this->verificaAluno($this->params['pessoa'], $this->params['periodoIngresso'], $this->params['grade'])) {
            $_SESSION['error'] = "Aluno já existente!";
            $this->redirect($this->action, "create", null);
        } else {
            $aluno = new Aluno();
            $periodo = new Periodo();
            $grade = new Grade();
            $arrayPeriodo = $periodo->get($this->params['periodoIngresso']);
            $arrayGrade = $grade->get($this->params['grade']);
            $this->params['matricula'] = $aluno->createMatricula(substr(str_replace(".", "", $arrayPeriodo['dados']['codigo']), 2, 3) . substr($arrayGrade['dados']['codigo'], 0, 3));
            $this->params['modulo'] = "01";
            if ($aluno->save($this->params)) {
                $_SESSION['flash'] = "Aluno salvo com Sucesso!";
                $this->redirect($this->action, "show", array("id" => $aluno->id));
            } else {
                $_SESSION['error'] = "Ocorreu um erro ao salvar o Aluno!";
                $this->redirect($this->action, "create", null);
            }
        }
    }

    public function _UPDATE() {
        $aluno = new Aluno();
        if ($aluno->update($this->params)) {
            $_SESSION['flash'] = "Aluno alterado com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $aluno->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Aluno!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _UPDATEATIVIDADE() {
        $aluno = new Aluno();
        if ($aluno->updateAtividade($this->params)) {
            $_SESSION['flash'] = "Atividades Complementares alterada com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $aluno->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar as Atividades Complementares!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        }
    }

    public function _DELETE() {
        $aluno = new Aluno();
        if ($aluno->delete($this->params)) {
            $_SESSION['flash'] = "Aluno deletado com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar o Aluno!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        }
    }

    public function verificaAluno($pessoa, $periodoIngresso, $grade) {
        $conection = new Conection();
        $query = "SELECT id FROM aluno 
                    WHERE pessoa_id = '$pessoa' AND
                          periodo_ingresso_id = '$periodoIngresso' AND 
                          grade_id = '$grade'";
        $result = $conection->selectQuery($query);
        if ($conection->rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function _result() {
        $conection = new Conection();
        $cpf = $this->params['cpf'];
        $nome = $this->params['nome'];
        $nomeResponsavel = $this->params['nomeResponsavel'];
        $matricula = $this->params['matricula'];
        $query = "SELECT a.*, p.nome, p.cpf FROM aluno a
                    INNER JOIN pessoa p ON a.pessoa_id = p.id
                    INNER JOIN pessoa rp ON a.responsavel_id = rp.id
                    WHERE p.cpf LIKE '$cpf%' AND
                          p.nome LIKE '$nome%' AND
                          rp.nome LIKE '$nomeResponsavel%' AND
                          a.matricula LIKE '$matricula%'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = new Enum();
        $this->render($this->action, "result", $arrayRetorno);
    }

    public function _resultReport() {
        $conection = new Conection();
        $cpf = $this->params['cpf'];
        $nome = $this->params['nome'];
        $nomeResponsavel = $this->params['nomeResponsavel'];
        $matricula = $this->params['matricula'];
        $formaIngresso = $this->params['formaIngresso'];
        $grade = $this->params['grade'];
        $turno = $this->params['turno'];
        $periodoIngresso = $this->params['periodoIngresso'];
        $query = "SELECT a.*, 
                            p.nome, 
                            p.cpf, 
                            p.email, 
                            p.telefone1, 
                            p.telefone2,
                            p.cep,
                            p.logradouro, 
                            p.numero,
                            p.complemento,
                            p.bairro,
                            p.cidade, 
                            p.estado
                            FROM aluno a
                    INNER JOIN pessoa p ON a.pessoa_id = p.id
                    INNER JOIN pessoa rp ON a.responsavel_id = rp.id
                    WHERE p.cpf LIKE '$cpf%' AND
                          p.nome LIKE '$nome%' AND
                          rp.nome LIKE '$nomeResponsavel%' AND
                          a.matricula LIKE '$matricula%' AND 
                          a.grade_id LIKE '$grade' AND 
                          a.turno LIKE '$turno' AND 
                          a.periodo_ingresso_id LIKE '$periodoIngresso' AND 
                          a.forma_ingresso LIKE '$formaIngresso'";
        $result = $conection->selectQuery($query);
        $data = array();
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['titulo'] = "Relatório Dados do Aluno";
        $data['result'] = $arrayRetorno;
        $this->class = new Enum();
        $this->renderReport($this->action, "result", $data);
    }

    public function _resultReportHistorico() {
        $conection = new Conection();
        $cpf = $this->params['cpf'];
        $matricula = $this->params['matricula'];
        $query = "SELECT
                    a.*,
                    g.carga_horaria,
                    p.nome,
                    p.cpf,
                    p.identidade,
                    p.orgao_emissor_identidade,
                    p.estado_identidade,
                    g.codigo,
                    c.codigo AS codigoCurso,
                    c.nome AS nomeCurso,
                    c.observacao,
                    pe.codigo AS periodoIngresso
                    FROM aluno a
                    INNER JOIN pessoa p ON a.pessoa_id = p.id
                    INNER JOIN grade g ON g.id = a.grade_id
                    INNER JOIN curso c ON c.id = g.curso_id
                    INNER JOIN periodo pe ON pe.id = a.periodo_ingresso_id
                    WHERE p.cpf = '$cpf' OR a.matricula = '$matricula'";
        $result = $conection->selectQuery($query);
        $data = array();
        $arrayRetorno = array();
        $data['cabecalho'] = array("dados" => $conection->fetch($result));

        $query = "SELECT
                    mtd.*,
                    m.situacao AS situacaoMatricula,
                    d.codigo,
                    d.nome,
                    d.carga_horaria,
                    pe.codigo AS periodo
                    FROM matricula_turma_disciplina mtd
                    INNER JOIN turma_disciplina td ON td.id = mtd.turma_disciplina_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    INNER JOIN matricula m ON mtd.matricula_id = m.id
                    INNER JOIN periodo pe ON pe.id = m.periodo_id
                    WHERE m.aluno_id = '" . $data['cabecalho']['dados']['id'] . "'
                    ORDER BY pe.codigo, d.nome, d.codigo";
        $result = $conection->selectQuery($query);
        $idPeriodo = 0;
        $situacao = 0;
        while ($array = $conection->fetch($result)) {
            $situacao = $array['situacaoMatricula'];
            if ($situacao != 'ME') {
                if ($idPeriodo != $array['periodo']) {
                    $idPeriodo = $array['periodo'];
                    $array['carga_horaria'] = "--";
                    $array['resultado_final'] = "--";
                    $array['situacao'] = "--";
                    $array['codigo'] = "--";
                    $array['nome'] = "Matricula Trancada";
                    $arrayRetorno[] = array("dados" => $array);
                }
            } else {
                $idPeriodo = $array['periodo'];
                $arrayRetorno[] = array("dados" => $array);
            }
        }
        if ($this->params['tipo'] == "Conferencia") {
            $data['titulo'] = "Histórico do Aluno para simples conferência";
        } else {
            $data['titulo'] = "Histórico do Aluno";
        }
        $data['result'] = $arrayRetorno;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "number" => new Number(), "formaIngresso" => new FormaDeIngresso(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->renderReport($this->action, "resultHistorico", $data);
    }

    public function _resultReportRDM() {
        $conection = new Conection();
        $cpf = $this->params['cpf'];
        $matricula = $this->params['matricula'];
        $periodo = $this->params['periodo'];
        $query = "SELECT 
                    a.id, 
                    p.nome, 
                    p.cpf, 
                    a.matricula, 
                    a.turno, 
                    t.codigo AS turma, 
                    c.codigo AS curso, 
                    c.nome AS nomeCurso, 
                    pe.codigo AS periodo,
                    m.situacao FROM pessoa p
                    INNER JOIN aluno a ON a.pessoa_id = p.id
                    INNER JOIN matricula m ON m.aluno_id = a.id
                    INNER JOIN periodo pe ON pe.id = m.periodo_id AND pe.id = '$periodo'
                    INNER JOIN turma t ON t.id = m.turma_id
                    INNER JOIN grade g ON a.grade_id = g.id
                    INNER JOIN curso c ON c.id = g.curso_id
                    WHERE a.matricula = '$matricula' OR p.cpf = '$cpf'";
        $result = $conection->selectQuery($query);
        $data = array();
        $arrayRetorno = array();
        $data['cabecalho'] = array("dados" => $conection->fetch($result));

        $query = "SELECT
                    mtd.*,
                    m.situacao AS situacaoMatricula,
                    d.codigo,
                    d.nome,
                    d.carga_horaria,
                    pe.codigo AS periodo
                    FROM matricula_turma_disciplina mtd
                    INNER JOIN turma_disciplina td ON td.id = mtd.turma_disciplina_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    INNER JOIN matricula m ON mtd.matricula_id = m.id
                    INNER JOIN periodo pe ON pe.id = m.periodo_id AND pe.id = '$periodo'
                    WHERE m.aluno_id = '" . $data['cabecalho']['dados']['id'] . "'
                    ORDER BY pe.codigo, d.nome, d.codigo";
        $result = $conection->selectQuery($query);
        $idPeriodo = 0;
        $situacao = 0;
        while ($array = $conection->fetch($result)) {
            $situacao = $array['situacaoMatricula'];
            if ($situacao != 'ME') {
                if ($idPeriodo != $array['periodo']) {
                    $idPeriodo = $array['periodo'];
                    $array['carga_horaria'] = "--";
                    $array['resultado_final'] = "--";
                    $array['situacao'] = "--";
                    $array['codigo'] = "--";
                    $array['nome'] = "Matricula Trancada";
                    $arrayRetorno[] = array("dados" => $array);
                }
            } else {
                $idPeriodo = $array['periodo'];
                $arrayRetorno[] = array("dados" => $array);
            }
        }

        $data['result'] = $arrayRetorno;
        $data['titulo'] = "Relação das Disciplinas Matriculadas - RDM";
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "number" => new Number(), "turno" => new Turno(), "formaIngresso" => new FormaDeIngresso(), "situacaoPeriodo" => new SituacaoPeriodo());
        $this->renderReport($this->action, "resultRDM", $data);
    }
    
}

?>