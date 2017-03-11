<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GradeController
 *
 * @author Alisson
 */
include_once '../class/Curso.php';
include_once '../class/Grade.php';
include_once '../class/Modulo.php';
include_once '../class/ModuloDisciplina.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/util/Data.php';
include_once '../function/util/Number.php';

class GradeController extends MainController {

    public $action;
    public $method;
    public $params;

    public function GradeController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_report", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_result", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_resultReport", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $grade = new Grade();
        $zebraPagination = $this->paginate($grade->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], 'number' => new Number(), 'enum' => new Enum(), 'data' => new Data());
        $data = $grade->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $curso = new Curso();
        $arrayCursos = $curso->listar("1");
        $array = array();
        foreach ($arrayCursos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['nome']);
        }
        $data['cursos'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML());
        $this->render($this->action, "create", $data);
    }

    public function _show() {
        $grade = new Grade();
        $data = $grade->get($this->params['id']);
        $this->class = array('number' => new Number(), 'enum' => new Enum(), 'data' => new Data());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $grade = new Grade();
        $data = $grade->get($this->params['id']);
        $this->class = array('funcoesHTML' => new FuncoesHTML(), 'enum' => new Enum(), 'data' => new Data());
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $curso = new Curso();
        $arrayCursos = $curso->listar("%");
        $array = array();
        foreach ($arrayCursos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['nome']);
        }
        $data['cursos'] = $array;
        $this->class = array('funcoesHTML' => new FuncoesHTML());
        $this->render($this->action, "search", $data);
    }

    public function _report() {
        $curso = new Curso();
        $arrayCursos = $curso->listar("%");
        $array = array();
        foreach ($arrayCursos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['nome']);
        }
        $data['cursos'] = $array;
        $this->class = array('funcoesHTML' => new FuncoesHTML());
        $this->render($this->action, "report", $data);
    }

    public function _SAVE() {
        $grade = new Grade();
        $data = new Data();
        $this->params['inicio'] = $data->dataBrasilToDataUSA($this->params['inicio']);
        $this->params['termino'] = $data->dataBrasilToDataUSA($this->params['termino']);
        if ($grade->save($this->params)) {
            $_SESSION['flash'] = "Grade salvo com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $grade->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar a Grade!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _UPDATE() {
        $grade = new Grade();
        $data = new Data();
        $this->params['inicio'] = $data->dataBrasilToDataUSA($this->params['inicio']);
        $this->params['termino'] = $data->dataBrasilToDataUSA($this->params['termino']);
        if ($grade->update($this->params)) {
            $_SESSION['flash'] = "Grade alterado com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $grade->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Grade!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $grade = new Grade();
        if ($grade->delete($this->params)) {
            $_SESSION['flash'] = "Grade deletado com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Grade!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _result() {
        $conection = new Conection();
        $curso = $this->params['curso'];
        $codigo = $this->params['codigo'];
        $status = $this->params['status'];
        $query = "SELECT g.*, c.nome FROM grade g
                    INNER JOIN curso c ON g.curso_id = c.id
                    WHERE g.curso_id LIKE '$curso%' AND
                          g.codigo LIKE '$codigo%' AND 
                          g.status LIKE '$status'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = array('number' => new Number(), 'enum' => new Enum(), 'data' => new Data());
        $this->render($this->action, "result", $arrayRetorno);
    }

    public function _resultReport() {
        $conection = new Conection();
        $curso = $this->params['curso'];
        $codigo = $this->params['codigo'];
        $status = $this->params['status'];
        if ($this->params['tipo'] == "Sintetico") {
            $query = "SELECT g.*, c.nome FROM grade g
                    INNER JOIN curso c ON g.curso_id = c.id
                    WHERE g.curso_id LIKE '$curso%' AND
                          g.codigo LIKE '$codigo%' AND 
                          g.status LIKE '$status'";
            $result = $conection->selectQuery($query);
            $arrayRetorno = array();
            while ($array = $conection->fetch($result)) {
                $arrayRetorno[] = array("dados" => $array);
            }
            $data['titulo'] = "Relatório Estruturas Curriculares<br /> Sintético";
        } else {
            $query = "SELECT g.*, c.nome FROM grade g
                    INNER JOIN curso c ON g.curso_id = c.id
                    WHERE g.curso_id LIKE '$curso%' AND
                          g.codigo LIKE '$codigo%' AND 
                          g.status LIKE '$status'";
            $result = $conection->selectQuery($query);
            $arrayRetorno = array();
            $modulo = new Modulo();
            $moduloDisciplina = new ModuloDisciplina();
            while ($array = $conection->fetch($result)) {
                $arrayModulos = array();
                foreach ($modulo->listar($array['id']) as $value) {
                    $value['dados']['moduloDisciplina'] = $moduloDisciplina->listar($value['dados']['id']);
                    $arrayModulos[] = $value;
                }
                $array['modulo'] = $arrayModulos;
                $arrayRetorno[] = array("dados" => $array);
            }
            $data['titulo'] = "Relatório Estruturas Curriculares<br /> Analítico";
        }
        $data['result'] = $arrayRetorno;
        $this->class = array('number' => new Number(), 'enum' => new Enum(), 'data' => new Data());
        $this->renderReport($this->action, "result" . $this->params['tipo'], $data);
    }

}

?>
