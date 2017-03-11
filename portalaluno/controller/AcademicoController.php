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
include_once 'MainController.php';
include_once '../../function/Enum.php';
include_once '../../function/FuncoesHTML.php';
include_once '../../function/util/Number.php';
include_once '../../function/util/Data.php';
include_once '../../function/enum/FormaDeIngresso.php';
include_once '../../function/enum/SituacaoDisciplina.php';

class AcademicoController extends MainController {

    public $params;

    public function _index() {
        $this->_historico();
    }

    public function _historico() {
        $conection = new Conection();
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
                    WHERE a.id = '" . $_SESSION['id'] . "'";
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
                    WHERE m.aluno_id = '" . $_SESSION['id'] . "'
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
        $data = $arrayRetorno;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "number" => new Number(), "formaIngresso" => new FormaDeIngresso(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "historico", $data);
    }
    
    public function _historicoReport() {
        $conection = new Conection();
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
                    WHERE a.id = '" . $_SESSION['id'] . "'";
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
                    WHERE m.aluno_id = '" . $_SESSION['id'] . "'
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
        $data['titulo'] = "Histórico do Aluno para simples conferência";
        $data['result'] = $arrayRetorno;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "number" => new Number(), "formaIngresso" => new FormaDeIngresso(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "historico", $data);
    }

}

?>
