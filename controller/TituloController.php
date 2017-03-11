<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TituloController
 *
 * @author Alisson
 */
include_once '../class/Titulo.php';
include_once '../class/Aluno.php';
include_once '../class/Baixa.php';
include_once '../class/Acrescimo.php';
include_once '../class/Desconto.php';
include_once '../class/Matricula.php';
include_once '../class/Plano.php';
include_once '../class/Parcela.php';
include_once '../class/Configuracao.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/util/Number.php';
include_once '../function/util/Data.php';
include_once '../function/enum/SituacaoTitulo.php';

class TituloController extends MainController {

    public $action;
    public $method;
    public $params;

    public function TituloController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_listByMatricula", "authority" => 4);
	$this->authorityMethod[] = array("name" => "_listByAluno", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_regenerate", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_showByMatricula", "authority" => 4);
	$this->authorityMethod[] = array("name" => "_showByAluno", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_getTitulo", "authority" => 4);
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
        $titulo = new Titulo();
        $zebraPagination = $this->paginate($titulo->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum(), "situacaoTitulo" => new SituacaoTitulo(), "number" => new Number(), "data" => new Data());
        foreach ($titulo->listarLimit($zebraPagination['limit']) as $value) {
            if ($value['dados']['situacao'] != "B" && $value['dados']['status'] == "1" && strtotime(date("Y-m-d")) > strtotime($value['dados']['vencimento'])) {
                $value['dados']['situacao'] = "V";
            }
            $data[] = $value;
        }
        $this->render($this->action, "list", $data);
    }

    public function _listByMatricula() {
        $titulo = new Titulo();
        $matricula = new Matricula();
        $this->class = array("enum" => new Enum(), "situacaoTitulo" => new SituacaoTitulo(), "number" => new Number(), "data" => new Data());
        $data = $matricula->get($this->params['m']);
        $data['matricula'] = $data['dados'];
        $data['titulos'] = array();
        foreach ($titulo->listarByMatricula($this->params['m']) as $value) {
            if ($value['dados']['situacao'] != "B" && $value['dados']['status'] == "1" && strtotime(date("Y-m-d")) > strtotime($value['dados']['vencimento'])) {
                $value['dados']['situacao'] = "V";
            }
            $data['titulos'][] = $value;
        }
        $this->render($this->action, "listByMatricula", $data);
    }
    
    public function _listByAluno() {
        $titulo = new Titulo();
        $aluno = new Aluno();
        $this->class = array("enum" => new Enum(), "situacaoTitulo" => new SituacaoTitulo(), "number" => new Number(), "data" => new Data());
        $data = $aluno->get($this->params['aluno']);
        $data['aluno'] = $data['dados'];
        $data['titulos'] = array();
        foreach ($titulo->listarByAluno($this->params['aluno']) as $value) {
            if ($value['dados']['situacao'] != "B" && $value['dados']['status'] == "1" && strtotime(date("Y-m-d")) > strtotime($value['dados']['vencimento'])) {
                $value['dados']['situacao'] = "V";
            }
            $data['titulos'][] = $value;
        }
        $this->render($this->action, "listByAluno", $data);
    }

    public function _regenerate() {
        $matricula = new Matricula();
        $parcelaInstance = new Parcela();
        $data = $matricula->get($this->params['matricula']);
        $data['matricula'] = $data['dados'];
        $tituloInstance = new Titulo();
        $arrayTitulo = $tituloInstance->listarByMatricula($data['matricula']['id']);
        $arrayParcelas = $parcelaInstance->getByMatriucula($data['matricula']['id']);
        foreach ($arrayParcelas as $parcelaValue) {
            $contain = false;
            foreach ($arrayTitulo as $tituloValue) {
                if($tituloValue['dados']['parcela_id'] == $parcelaValue['dados']['id']){
                    $contain = true;
                }
            }
            
            if(!$contain){
                $nossoNumero = $tituloInstance->getMaxNossoNumero();
                if (substr($nossoNumero, 0, 6) < date("Ym")) {
                    $nossoNumero = date("Ym") . "00000";
                }
                $this->params['nossoNumero'] = $nossoNumero + 1;
                $params = array("parcela" => $parcelaValue['dados']['id'],
                                "matricula" => $data['matricula']['id'],
                                "configuracao" => $data['matricula']['configuracao'],
                                "nossoNumero" => $nossoNumero + 1,
                                "valor" => $parcelaValue['dados']['valor'],
                                "vencimento" => $parcelaValue['dados']['data_vencimento'],
                                "situacao" => "A",
                                "status" => 1,
                                "linhaDigitavel" => "",
                                "observacao" => "",
                                "userCreate" => $this->params['userCreate']
                            );
                               
                if (!$tituloInstance->save($params)) {
                    $_SESSION['error'] = "Ocorreu um erro ao regerar o Título!";
                    $this->redirect($this->action, "listByMatricula", array("id" => "?m=" . $this->params['matricula']));
                    return;
                }
            }
        }
        $_SESSION['flash'] = "Títulos Regerados com Sucesso!";
        $this->redirect($this->action, "listByMatricula", array("id" => "?m=" . $this->params['matricula']));
    }

    private function createTitulos($idPlano, $idMatricula) {
        $titulo = new Titulo();
        $parcela = new Parcela();
        $arrayParcelas = $parcela->listar($idPlano);
        $nossoNumero = $titulo->getMaxNossoNumero();
        if (substr($nossoNumero, 0, 6) < date("Ym")) {
            $nossoNumero = date("Ym") . "00000";
        }
        foreach ($arrayParcelas as $parcela) {
            if (!$titulo->isExistTitulo($idMatricula, $parcela['dados']['id'])) {
                $nossoNumero = $nossoNumero + 1;
                $params = array("parcela" => $parcela['dados']['id'],
                    "matricula" => $idMatricula,
                    "configuracao" => $parcela['dados']['configuracao'],
                    "nossoNumero" => $nossoNumero,
                    "vencimento" => $parcela['dados']['data_vencimento'],
                    "valor" => $parcela['dados']['valor'],
                    "situacao" => "A",
                    "status" => 1,
                    "linhaDigitavel" => "",
                    "observacao" => "",
                    "userCreate" => $this->params['userCreate']
                );
                if (!$idTitulo = $titulo->save($params)) {
                    return false;
                    die();
                }
            }
        }
        return true;
    }

    public function _getTitulo() {
        $titulo = new Titulo();
        $array = array();
        $data = new Data();
        $number = new Number();
        $nossoNumero = $this->params['key'];
        if ($this->params['type'] == 'codigoBarras') {
            $nossoNumero = substr($this->params['key'], 29, 15);
        }
        foreach ($titulo->findByNossoNumero($nossoNumero) as $value) {
            if ($value['dados']['situacao'] != "B" && $value['dados']['status'] != "0") {
                $array[] = array("id" => $value['dados']['id'], "valor" => $number->formatCurrency($value['dados']['valor_restante']), "valorMulta" => $number->formatCurrency($value['dados']['valor_multa']), "valorJuros" => $number->formatCurrency($value['dados']['valor_juros']), "valorDesconto" => $number->formatCurrency($value['dados']['valor_desconto']), "data" => $data->dataUSAToDataBrasil($value['dados']['data']), "codigoBarras" => $value['dados']['linha_digitavel']);
            }
        }
        echo json_encode($array);
    }

    private function getAcrescimos($idTitulo) {
        $acrescimo = new Acrescimo();
        $valor = 0;
        foreach ($acrescimo->listarByTitulo($idTitulo) as $value) {
            $valor = $valor + $value['dados']['valor'];
        }
        return $valor;
    }

    private function getDescontos($idTitulo) {
        $desconto = new Desconto();
        $valor = 0;
        foreach ($desconto->listarByTitulo($idTitulo) as $value) {
            $valor = $valor + $value['dados']['valor'];
        }
        return $valor;
    }

    private function getBaixas($idTitulo) {
        $baixa = new Baixa();
        $valor = 0;
        foreach ($baixa->listarByTitulo($idTitulo) as $value) {
            $valor = $valor + $value['dados']['valor_pago'];
        }
        return $valor;
    }

    public function _create() {
        $configuracao = new Configuracao();
        $array = array();
        foreach ($configuracao->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['nome_banco'] . " - " . $value['dados']['agencia'] . " - " . $value['dados']['conta']);
        }
        $data['configuracao'] = $array;
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "situacaoTitulo" => new SituacaoTitulo(), 'enum' => new Enum(), "number" => new Number, "data" => new Data());
        $this->render($this->action, "create", $data);
    }

    public function _show() {
        $titulo = new Titulo();
        $data = $titulo->get($this->params['id']);
        if ($data['dados']['situacao'] != "B" && $data['dados']['status'] == "1" && strtotime(date("Y-m-d")) > strtotime($data['dados']['vencimento'])) {
            $data['dados']['situacao'] = "V";
        }
        $this->class = array("enum" => new Enum(), "situacaoTitulo" => new SituacaoTitulo(), "number" => new Number(), "data" => new Data());
        $this->render($this->action, "show", $data);
    }

    public function _showByMatricula() {
        $titulo = new Titulo();
        $data = $titulo->get($this->params['id']);
        if ($data['dados']['situacao'] != "B" && $data['dados']['status'] == "1" && strtotime(date("Y-m-d")) > strtotime($data['dados']['vencimento'])) {
            $data['dados']['situacao'] = "V";
        }
        $this->class = array("enum" => new Enum(), "situacaoTitulo" => new SituacaoTitulo(), "number" => new Number(), "data" => new Data());
        $this->render($this->action, "showByMatricula", $data);
    }
    
    public function _showByAluno() {
        $titulo = new Titulo();
        $data = $titulo->get($this->params['id']);
        if ($data['dados']['situacao'] != "B" && $data['dados']['status'] == "1" && strtotime(date("Y-m-d")) > strtotime($data['dados']['vencimento'])) {
            $data['dados']['situacao'] = "V";
        }
        $this->class = array("enum" => new Enum(), "situacaoTitulo" => new SituacaoTitulo(), "number" => new Number(), "data" => new Data());
        $this->render($this->action, "showByAluno", $data);
    }

    public function _edit() {
        $titulo = new Titulo();
        $data['titulo'] = $titulo->get($this->params['id']);
        $configuracao = new Configuracao();
        $array = array();
        foreach ($configuracao->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['nome_banco'] . " - " . $value['dados']['agencia'] . " - " . $value['dados']['conta']);
        }
        $data['configuracao'] = $array;
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "situacaoTitulo" => new SituacaoTitulo(), 'enum' => new Enum(), "number" => new Number, "data" => new Data());
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "situacaoTitulo" => new SituacaoTitulo());
        $this->render($this->action, "search", null);
    }

    public function _report() {
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "situacaoTitulo" => new SituacaoTitulo());
        $this->render($this->action, "report", null);
    }

    public function _SAVE() {
        $titulo = new Titulo();
        $number = new Number();
        $data = new Data();
        $this->params['valor'] = $number->formatCurrency($this->params['valor']);
        $this->params['vencimento'] = $data->dataBrasilToDataUSA($this->params['vencimento']);
        $this->params['linhaDigitavel'] = "";
        $this->params['status'] = 1;
        $this->params['situacao'] = "A";
        $nossoNumero = $titulo->getMaxNossoNumero();
        if (substr($nossoNumero, 0, 6) < date("Ym")) {
            $nossoNumero = date("Ym") . "00000";
        }
        $this->params['nossoNumero'] = $nossoNumero + 1;
        if ($titulo->saveByAluno($this->params)) {
            $_SESSION['flash'] = "Título salvo com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $titulo->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar o Título!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _UPDATE() {
        $titulo = new Titulo();
        $number = new Number();
        $data = new Data();
        $this->params['valor'] = $number->formatCurrency($this->params['valor']);
        $this->params['vencimento'] = $data->dataBrasilToDataUSA($this->params['vencimento']);
        if ($titulo->update($this->params)) {
            $_SESSION['flash'] = "Título alterado com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $titulo->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Título!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $titulo = new Titulo();
        if ($titulo->delete($this->params)) {
            $_SESSION['flash'] = "Título deletado com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar o Título!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _result() {
        $conection = new Conection();
        $nossoNumero = $this->params['nossoNumero'];
        $matricula = $this->params['matricula'];
        $nome = $this->params['nome'];
        $valor = "";
        if ($this->params['valor'] != "") {
            $valor = "t.valor = '" . $this->params['valor'] . "' AND";
        }
        $vencimento = "";
        if ($this->params['vencimento'] != "") {
            $vencimento = "t.vencimento = '" . $this->params['vencimento'] . "' AND";
        }
        $situacao = $this->params['situacao'];
        $status = $this->params['status'];
        $query = "(SELECT t.*, p.nome, p.cpf, a.matricula FROM titulo t
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    WHERE t.nosso_numero LIKE '$nossoNumero%' AND 
                          a.matricula LIKE '$matricula%' AND 
                          p.nome LIKE '$nome%' AND 
                          " . $valor . $vencimento . " 
                          t.situacao LIKE '$situacao' AND 
                          t.status LIKE '$status')
                  UNION
                  (SELECT t.*, p.nome, p.cpf, a.matricula FROM titulo t
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    WHERE t.nosso_numero LIKE '$nossoNumero%' AND 
                          a.matricula LIKE '$matricula%' AND 
                          p.nome LIKE '$nome%' AND 
                          " . $valor . $vencimento . " 
                          t.situacao LIKE '$situacao' AND 
                          t.status LIKE '$status')";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            if ($array['situacao'] != "B" && $array['status'] == "1" && strtotime(date("Y-m-d")) > strtotime($array['vencimento'])) {
                $array['situacao'] = "V";
            }
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = array("enum" => new Enum(), "situacaoTitulo" => new SituacaoTitulo(), "number" => new Number(), "data" => new Data());
        $this->render($this->action, "result", $arrayRetorno);
    }

    public function _resultReport() {
        $conection = new Conection();
        $nossoNumero = $this->params['nossoNumero'];
        $matricula = $this->params['matricula'];
        $nome = $this->params['nome'];
        $valor = "";
        if ($this->params['valor'] != "") {
            $valor = "t.valor = '" . $this->params['valor'] . "' AND";
        }
        $vencimento = "";
        if ($this->params['vencimento'] != "") {
            $vencimento = "t.vencimento = '" . $this->params['vencimento'] . "' AND";
        }
        $situacao = $this->params['situacao'];
        $status = $this->params['status'];
        $query = "(SELECT t.*, p.nome, p.cpf, a.matricula FROM titulo t
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    WHERE t.nosso_numero LIKE '$nossoNumero%' AND 
                          a.matricula LIKE '$matricula%' AND 
                          p.nome LIKE '$nome%' AND 
                          " . $valor . $vencimento . " 
                          t.situacao LIKE '$situacao' AND 
                          t.status LIKE '$status')
                  UNION
                  (SELECT t.*, p.nome, p.cpf, a.matricula FROM titulo t
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    WHERE t.nosso_numero LIKE '$nossoNumero%' AND 
                          a.matricula LIKE '$matricula%' AND 
                          p.nome LIKE '$nome%' AND 
                          " . $valor . $vencimento . " 
                          t.situacao LIKE '$situacao' AND 
                          t.status LIKE '$status')";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            if ($array['situacao'] != "B" && $array['status'] == "1" && strtotime(date("Y-m-d")) > strtotime($array['vencimento'])) {
                $array['situacao'] = "V";
            }
            $arrayRetorno[] = array("dados" => $array);
        }
        if ($this->params['type'] == "A") {
            $data['titulo'] = "Relatório de Títulos - Analítico";
            $report = "resultAnalitico";
        } else {
            $data['titulo'] = "Relatório de Títulos - Sintético";
            $report = "resultSintetico";
        }
        $data['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "situacaoTitulo" => new SituacaoTitulo(), "number" => new Number(), "data" => new Data());
        $this->renderReport($this->action, $report, $data);
    }

}

?>
