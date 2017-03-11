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
include_once '../class/Parcela.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/enum/Numbers.php';
include_once '../function/enum/Meses.php';
include_once '../function/util/Number.php';
include_once '../function/util/Data.php';
include_once '../function/FuncoesHTML.php';

class ParcelaController extends MainController {

    public $action;
    public $method;
    public $params;

    public function ParcelaController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $plano = new Plano();
        $data = $plano->get($this->params['plano']);
        $data['plano'] = $data['dados'];
        $parcela = new Parcela();
        $data['parcelas'] = $parcela->listar($this->params['plano']);
        $this->class = array('enum' => new Enum(), "number" => new Number, "data" => new Data(), "meses" => new Meses());
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $data = $this->params;
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum(), "numbers" => new Numbers(), "meses" => new Meses());
        $this->render($this->action, "create", $data);
    }

    public function _show() {
        $parcela = new Parcela();
        $data = $parcela->get($this->params['id']);
        $this->class = array('enum' => new Enum(), "number" => new Number, "data" => new Data(), "meses" => new Meses());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $parcela = new Parcela();
        $data = $parcela->get($this->params['id']);
        $this->class = array('funcoesHTML' => new FuncoesHTML(), 'enum' => new Enum(), "number" => new Number, "data" => new Data(), "numbers" => new Numbers(), "meses" => new Meses());
        $this->render($this->action, "edit", $data);
    }

    public function _SAVE() {
        $number = new Number();
        $data = new Data();
        $this->params['valor'] = $number->formatCurrency($this->params['valor']);
        $this->params['vencimento'] = $data->dataBrasilToDataUSA($this->params['vencimento']);
        $parcela = new Parcela();
        if ($parcela->save($this->params)) {
            $_SESSION['flash'] = "Parcela salva com Sucesso!";
            $this->redirect($this->action, "list", array("id" => "?plano=" . $this->params['plano']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar a Parcela!";
            $this->redirect($this->action, "list", array("id" => "?plano=" . $this->params['plano']));
        }
    }

    public function _UPDATE() {
        $number = new Number();
        $data = new Data();
        $this->params['valor'] = $number->formatCurrency($this->params['valor']);
        $this->params['vencimento'] = $data->dataBrasilToDataUSA($this->params['vencimento']);
        $parcela = new Parcela();
        if ($parcela->update($this->params)) {
            $_SESSION['flash'] = "Parcela alterada com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Parcela!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        }
    }

    public function _DELETE() {
        $parcela = new Parcela();
        $data = $parcela->get($this->params['id']);
        if ($parcela->delete($this->params)) {
            $_SESSION['flash'] = "Parcela deletada com Sucesso!";
            $this->redirect($this->action, "list", array("id" => "?plano=" . $data['dados']['plano_id']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Parcela!";
            $this->redirect($this->action, "list", array("id" => "?plano=" . $data['dados']['plano_id']));
        }
    }

}

?>