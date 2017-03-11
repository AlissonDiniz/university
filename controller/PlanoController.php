<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlanoController
 *
 * @author Alisson
 */
include_once '../class/Plano.php';
include_once '../class/Curso.php';
include_once '../class/Configuracao.php';
include_once '../class/Periodo.php';
include_once '../class/Parametro.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/enum/Numbers.php';
include_once '../function/util/Number.php';
include_once '../function/FuncoesHTML.php';

class PlanoController extends MainController {

    public $action;
    public $method;
    public $params;

    public function PlanoController() {
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
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $plano = new Plano();
        $zebraPagination = $this->paginate($plano->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], 'enum' => new Enum(), "number" => new Number);
        $data = $plano->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $data = array();
        $configuracao = new Configuracao();
        $array = array();
        foreach ($configuracao->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['nome_banco'] . " - " . $value['dados']['agencia'] . " - " . $value['dados']['conta']);
        }
        $data['configuracoes'] = $array;
        $curso = new Curso();
        $array = array();
        foreach ($curso->listar("1") as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['cursos'] = $array;
        $parametro = new Parametro();
        $arrayParametros = $parametro->get();
        $array = array();
        foreach ($arrayParametros as $value) {
            $array['periodo_matricula_id'] = $value['periodo_matricula_id'];
        }
        $data['parametros'] = $array;
        $periodo = new Periodo();
        $array = array();
        foreach ($periodo->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum(), "numbers" => new Numbers());
        $this->render($this->action, "create", $data);
    }

    public function _show() {
        $plano = new Plano();
        $data = $plano->get($this->params['id']);
        $this->class = array('enum' => new Enum(), "number" => new Number());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $plano = new Plano();
        $data = $plano->get($this->params['id']);
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum(), "number" => new Number(), "numbers" => new Numbers());
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $data = array();
        $curso = new Curso();
        $array = array();
        foreach ($curso->listar("1") as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['cursos'] = $array;
        $parametro = new Parametro();
        $arrayParametros = $parametro->get();
        $array = array();
        foreach ($arrayParametros as $value) {
            $array['periodo_matricula_id'] = $value['periodo_matricula_id'];
        }
        $data['parametros'] = $array;
        $periodo = new Periodo();
        $array = array();
        foreach ($periodo->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum(), "numbers" => new Numbers());
        $this->render($this->action, "search", $data);
    }

    public function _report() {
        $data = array();
        $curso = new Curso();
        $array = array();
        foreach ($curso->listar("1") as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['cursos'] = $array;
        $parametro = new Parametro();
        $arrayParametros = $parametro->get();
        $array = array();
        foreach ($arrayParametros as $value) {
            $array['periodo_matricula_id'] = $value['periodo_matricula_id'];
        }
        $data['parametros'] = $array;
        $periodo = new Periodo();
        $array = array();
        foreach ($periodo->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum(), "numbers" => new Numbers());
        $this->render($this->action, "report", $data);
    }

    public function _SAVE() {
        $number = new Number();
        $this->params['valor'] = $number->formatCurrency($this->params['valor']);
        $plano = new Plano();
        if ($plano->save($this->params)) {
            $_SESSION['flash'] = "Plano de Pagamento salvo com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $plano->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar o Plano de Pagamento!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _UPDATE() {
        $number = new Number();
        $this->params['valor'] = $number->formatCurrency($this->params['valor']);
        $plano = new plano();
        if ($plano->update($this->params)) {
            $_SESSION['flash'] = "Plano de Pagamento alterado com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $plano->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Plano de Pagamento!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $plano = new Plano();
        if ($plano->delete($this->params)) {
            $_SESSION['flash'] = "Plano de Pagamento deletado com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar o Plano de Pagamento!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _result() {
        $conection = new Conection();
        $periodo = $this->params['periodo'];
        $curso = $this->params['curso'];
        $descricao = $this->params['descricao'];
        $status = $this->params['status'];
        $query = "SELECT p.*, pe.codigo AS periodo, co.nome_banco AS banco, co.agencia, co.conta, c.nome AS curso FROM plano p
                    INNER JOIN configuracao co ON co.id = p.configuracao_id
                    INNER JOIN periodo pe ON pe.id = p.periodo_id
                    INNER JOIN curso c ON c.id = p.curso_id
                    WHERE c.id LIKE '$curso%' AND
                          pe.id LIKE '$periodo%' AND 
                          p.descricao LIKE '$descricao%' AND
                          p.status LIKE '$status'
                    ORDER BY p.data DESC LIMIT 50 ";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = array('enum' => new Enum(), "number" => new Number);
        $this->render($this->action, "result", $arrayRetorno);
    }

    public function _resultReport() {
        $conection = new Conection();
        $data = array();
        $idCurso = $this->params['curso'];
        if ($idCurso != "%") {
            $curso = new Curso();
            $data['curso'] = $curso->get($idCurso);
        } else {
            $data['curso'] = array("dados" => array("codigo" => "", "nome" => "Todos"));
        }
        $idPeriodo = $this->params['periodo'];
        if ($idPeriodo != "%") {
            $periodo = new Periodo();
            $data['periodo'] = $periodo->get($idPeriodo);
        } else {
            $data['periodo'] = array("dados" => array("codigo" => "Todos"));
        }
        $descricao = $this->params['descricao'];
        $status = $this->params['status'];
        $query = "SELECT p.*, pe.codigo AS periodo, co.nome_banco AS banco, co.agencia, co.conta, c.nome AS curso FROM plano p
                    INNER JOIN configuracao co ON co.id = p.configuracao_id
                    INNER JOIN periodo pe ON pe.id = p.periodo_id
                    INNER JOIN curso c ON c.id = p.curso_id
                    WHERE c.id LIKE '$idCurso%' AND
                          pe.id LIKE '$idPeriodo%' AND 
                          p.descricao LIKE '$descricao%' AND
                          p.status LIKE '$status'
                    ORDER BY p.data DESC LIMIT 50 ";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['titulo'] = "Relatório de Planos de Pagamento";
        $data['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "number" => new Number());
        $this->renderReport($this->action, "result", $data);
    }

}

?>