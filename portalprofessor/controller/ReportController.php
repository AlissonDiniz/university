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
include_once 'MainController.php';
include_once '../../function/FuncoesHTML.php';
include_once '../../function/enum/Formula.php';
include_once '../../function/enum/SituacaoDisciplina.php';
include_once '../../function/Enum.php';
include_once '../../function/util/Number.php';
include_once '../../function/util/Data.php';
include_once '../class/TurmaDisciplina.php';
include_once '../class/Aula.php';

class ReportController extends MainController {

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

    public function _avaliacao() {
        $conection = new Conection();
        $turmaDisciplina = $this->params['id'];
        $query = "SELECT
                    a.matricula,
                    p.nome,
                    p.cpf
                    FROM turma_disciplina td
                    INNER JOIN matricula_turma_disciplina mtd On mtd.turma_disciplina_id = td.id
                    INNER JOIN matricula m ON m.id = mtd.matricula_id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    WHERE td.id = '$turmaDisciplina'
                    ORDER BY p.nome";
        $result = $conection->selectQuery($query);
        $data = array();
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['titulo'] = "Relatório Lista para Avaliação";
        $data['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "avaliacao", $data);
    }

    public function _alunos() {
        $conection = new Conection();
        $turmaDisciplina = $this->params['id'];
        $query = "SELECT
                    a.matricula,
                    p.nome,
                    p.cpf,
                    p.email,
                    mtd.situacao
                    FROM turma_disciplina td
                    INNER JOIN matricula_turma_disciplina mtd On mtd.turma_disciplina_id = td.id
                    INNER JOIN matricula m ON m.id = mtd.matricula_id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    WHERE td.id = '$turmaDisciplina'
                    ORDER BY p.nome";
        $result = $conection->selectQuery($query);
        $data = array();
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['titulo'] = "Relatório Alunos Matriculados";
        $data['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "alunos", $data);
    }

    public function _presenca() {
        $conection = new Conection();
        $turmaDisciplina = $this->params['id'];
        $query = "SELECT
                    a.matricula,
                    p.nome,
                    p.cpf
                    FROM turma_disciplina td
                    INNER JOIN matricula_turma_disciplina mtd On mtd.turma_disciplina_id = td.id
                    INNER JOIN matricula m ON m.id = mtd.matricula_id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    WHERE td.id = '$turmaDisciplina'
                    ORDER BY p.nome";
        $result = $conection->selectQuery($query);
        $data = array();
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['titulo'] = "Relatório Lista de Presença";
        $data['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "situacaoDisciplina" => new SituacaoDisciplina());
        $this->render($this->action, "presenca", $data);
    }

    public function _notas() {
        $conection = new Conection();
        $turmaDisciplina = $this->params['id'];
        $query = "SELECT
                    a.matricula,
                    p.nome,
                    p.cpf,
                    n.numero_etapa,
                    n.valor,
                    n.data
                    FROM turma_disciplina td
                    INNER JOIN matricula_turma_disciplina mtd On mtd.turma_disciplina_id = td.id
                    INNER JOIN matricula m ON m.id = mtd.matricula_id
                    INNER JOIN nota n ON n.matricula_turma_disciplina_id = mtd.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    WHERE td.id = '$turmaDisciplina'
                    ORDER BY p.nome, n.numero_etapa";
        $result = $conection->selectQuery($query);
        $data = array();
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['titulo'] = "Relatório Lançamento de Notas";
        $data['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "data" => new Data(), "number" => new Number());
        $this->render($this->action, "notas", $data);
    }

}

?>
