<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TurmaController
 *
 * @author Alisson
 */
include_once '../class/Turma.php';
include_once '../class/Grade.php';
include_once '../class/Parametro.php';
include_once '../class/Periodo.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/enum/Turno.php';
include_once '../function/enum/TurmaEnum.php';
include_once '../function/enum/ModuloEnum.php';

class TurmaController extends MainController {

    public $action;
    public $method;
    public $params;

    public function TurmaController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_result", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $turma = new Turma();
        $zebraPagination = $this->paginate($turma->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum(), "turno" => new Turno());
        $data = $turma->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $grade = new Grade();
        $parametro = new Parametro();
        $periodo = new Periodo();
        $arrayGrades = $grade->listarGradesAtivas();
        $array = array();
        foreach ($arrayGrades as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['grades'] = $array;
        $arrayParametros = $parametro->get();
        $array = array();
        foreach ($arrayParametros as $value) {
            $data['periodoAtual'] = $value['periodo_atual_id'];
        }
        $arrayPeriodos = $periodo->listar();
        $array = array();
        foreach ($arrayPeriodos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "turma" => new TurmaEnum(), "turno" => new Turno(), "modulo" => new ModuloEnum());
        $this->render($this->action, "create", $data);
    }

    public function _show() {
        $turma = new Turma();
        $data = $turma->get($this->params['id']);
        $this->class = array("enum" => new Enum(), "turno" => new Turno());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $turma = new Turma();
        $data = $turma->get($this->params['id']);
        $this->class = array("enum" => new Enum(), "turno" => new Turno());
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
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "turma" => new TurmaEnum(), "turno" => new Turno(), "modulo" => new ModuloEnum());
        $this->render($this->action, "search", $data);
    }

    public function _SAVE() {
        $grade = new Grade();
        $turma = new Turma();
        $arrayGrade = $grade->get($this->params['grade']);
        $this->params['codigo'] = $arrayGrade['dados']['codigo'] . $this->params['modulo'] . $this->params['turma'] . $this->params['turno'];
        $arrayTurma = $turma->getToCodigo($this->params['codigo'], $this->params['periodo']);
        $array = $arrayTurma['dados'];
        if ($array[2] != "") {
            $_SESSION['error'] = "Já existe uma turma para os dados informados!";
            $this->redirect($this->action, "create", null);
        } else {
            if ($turma->save($this->params)) {
                $_SESSION['flash'] = "Turma salva com Sucesso!";
                $this->redirect($this->action, "show", array("id" => $turma->id));
            } else {
                $_SESSION['error'] = "Ocorreu um erro ao salvar a Turma!";
                $this->redirect($this->action, "create", null);
            }
        }
    }

    public function _UPDATE() {
        $turma = new Turma();
        if ($turma->update($this->params)) {
            $_SESSION['flash'] = "Turma alterada com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $turma->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Turma!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $turma = new Turma();
        if ($turma->delete($this->params)) {
            $_SESSION['flash'] = "Turma deletada com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Turma!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _result() {
        $conection = new Conection();
        $codigo = $this->params['codigo'];
        $periodo = $this->params['periodo'];
        $modulo = $this->params['modulo'];
        $turma = $this->params['turma'];
        $turno = $this->params['turno'];
        $query = "SELECT t.*, p.codigo AS periodo, g.codigo AS codGrade, c.nome AS nomeCurso FROM turma t
                    INNER JOIN grade g ON g.id = t.grade_id
                    INNER JOIN curso c ON c.id = g.curso_id
                    INNER JOIN periodo p ON p.id = t.periodo_id 
                    WHERE t.codigo LIKE '$codigo%' AND
                          t.codigo LIKE '_____$modulo$turma$turno' AND 
                          t.periodo_id LIKE '$periodo%'
                    ORDER BY t.data DESC";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = array("enum" => new Enum(), "turno" => new Turno());
        $this->render($this->action, "result", $arrayRetorno);
    }

}

?>
