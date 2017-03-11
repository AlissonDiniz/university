<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaixaController
 *
 * @author Alisson
 */
include_once '../class/Baixa.php';
include_once '../class/Titulo.php';
include_once '../class/FormaPagamento.php';
include_once '../class/User.php';
include_once '../class/Grade.php';
include_once '../class/Turma.php';
include_once '../class/Periodo.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/util/Data.php';
include_once '../function/util/Number.php';
include_once '../function/enum/SituacaoTitulo.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';

class BaixaController extends MainController {

    public $action;
    public $method;
    public $params;

    public function BaixaController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_createGroup", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_report", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_reportByTurma", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_result", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_resultReport", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_resultReportByTurma", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $baixa = new Baixa();
        $zebraPagination = $this->paginate($baixa->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "number" => new Number(), "data" => new Data());
        $data = $baixa->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $formaPagamento = new FormaPagamento();
        $array = array();
        foreach ($formaPagamento->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['formasPagamento'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML());
        $this->render($this->action, "create", $data);
    }

    public function _createGroup() {
        $formaPagamento = new FormaPagamento();
        $array = array();
        foreach ($formaPagamento->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['formasPagamento'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML());
        $this->render($this->action, "createGroup", $data);
    }

    public function _show() {
        $baixa = new Baixa();
        $data = $baixa->get($this->params['id']);
        $this->class = array("number" => new Number(), "data" => new Data(), "situacaoTitulo" => new SituacaoTitulo());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $baixa = new Baixa();
        $data['baixa'] = $baixa->get($this->params['id']);
        $formaPagamento = new FormaPagamento();
        $array = array();
        foreach ($formaPagamento->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['formasPagamento'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "number" => new Number(), "data" => new Data(), "situacaoTitulo" => new SituacaoTitulo());
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $formaPagamento = new FormaPagamento();
        $array = array();
        foreach ($formaPagamento->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['formasPagamento'] = $array;
        $user = new User();
        $array = array();
        foreach ($user->listar() as $value) {
            $array[] = array("value" => $value['dados']['username'], "nome" => $value['dados']['nome']);
        }
        $data['usuarios'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML());
        $this->render($this->action, "search", $data);
    }

    public function _report() {
        $formaPagamento = new FormaPagamento();
        $array = array();
        foreach ($formaPagamento->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['formasPagamento'] = $array;
        $user = new User();
        $array = array();
        foreach ($user->listar() as $value) {
            $array[] = array("value" => $value['dados']['username'], "nome" => $value['dados']['nome']);
        }
        $data['usuarios'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML());
        $this->render($this->action, "report", $data);
    }
    
    public function _reportByTurma() {
        $formaPagamento = new FormaPagamento();
        $array = array();
        foreach ($formaPagamento->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['formasPagamento'] = $array;
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
        $this->render($this->action, "reportByTurma", $data);
    }

    public function _SAVE() {
        $baixa = new Baixa();
        $number = new Number();
        $data = new Data();
        $this->params['dataPagamento'] = $data->dataBrasilToDataUSA($this->params['dataPagamento']);
        $this->params['valorMulta'] = $number->formatCurrency($this->params['valorMulta']);
        $this->params['valorJuros'] = $number->formatCurrency($this->params['valorJuros']);
        $this->params['valorDesconto'] = $number->formatCurrency($this->params['valorDesconto']);

        $arrayPagamento = $this->createArrayPagamento($this->params['arrayFormaPagamento'], $this->params['arrayValorPago']);
        $titulo = new Titulo();
        if (!$titulo->updateValores($this->params)) {
            $this->redirect($this->action, "create", null);
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Título!";
            die();
        } else {
            foreach ($arrayPagamento as $value) {
                $this->params['valorPago'] = $value["pagamento"];
                $this->params['formaPagamento'] = $value["forma"];
                if (!$baixa->save($this->params)) {
                    $_SESSION['error'] = "Ocorreu um erro ao salvar a Baixa!";
                    $this->redirect($this->action, "create", null);
                    die();
                }
            }
            if (!$titulo->updateSituacao($this->params['idTitulo'])) {
                $this->redirect($this->action, "create", null);
                $_SESSION['error'] = "Ocorreu um erro ao alterar o Título!";
                die();
            }
        }
        $_SESSION['flash'] = "Baixa salva com Sucesso!";
        $this->redirect($this->action, "list", null);
    }

    private function createArrayPagamento($arrayFormaPagamento, $arrayValorPago) {
        $number = new Number();
        $arrayPagamento = array();
        foreach ($arrayFormaPagamento as $key => $value) {
            $arrayPagamento[] = array("forma" => $value, "pagamento" => $number->formatCurrency($arrayValorPago[$key]));
        }
        return $arrayPagamento;
    }

    public function _UPDATE() {
        $baixa = new Baixa();
        $arrayBaixa = $baixa->get($this->params['id']);
        $number = new Number();
        $data = new Data();
        $this->params['valorPago'] = $number->formatCurrency($this->params['valorPago']);
        $this->params['valorMulta'] = $number->formatCurrency($this->params['valorMulta']);
        $this->params['valorJuros'] = $number->formatCurrency($this->params['valorJuros']);
        $this->params['valorDesconto'] = $number->formatCurrency($this->params['valorDesconto']);
        $this->params['dataPagamento'] = $data->dataBrasilToDataUSA($this->params['dataPagamento']);
        $this->params['idTitulo'] = $arrayBaixa['dados']['titulo_id'];
        $titulo = new Titulo();
        if (!$titulo->updateValores($this->params)) {
            $this->redirect($this->action, "create", null);
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Título!";
            die();
        } else {
            if (!$baixa->update($this->params)) {
                $_SESSION['error'] = "Ocorreu um erro ao alterar a Baixa!";
                $this->redirect($this->action, "list", null);
                die();
            }
            if (!$titulo->updateSituacao($this->params['idTitulo'])) {
                $this->redirect($this->action, "create", null);
                $_SESSION['error'] = "Ocorreu um erro ao alterar o Título!";
                die();
            }
            $_SESSION['flash'] = "Baixa alterada com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $baixa->id));
        }
    }

    public function _DELETE() {
        $baixa = new Baixa();
        $arrayBaixa = $baixa->get($this->params['id']);
        if ($baixa->delete($this->params)) {
            $titulo = new Titulo();
            if (!$titulo->updateSituacao($arrayBaixa['dados']['titulo_id'])) {
                $this->redirect($this->action, "create", null);
                $_SESSION['error'] = "Ocorreu um erro ao alterar o Título!";
                die();
            }
            $_SESSION['flash'] = "Baixa deletada com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Baixa!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _result() {
        $conection = new Conection();
        $data = new Data();
        $number = new Number();
        $nossoNumero = $this->params['nossoNumero'];
        $nome = $this->params['nome'];
        $matricula = $this->params['matricula'];
        $this->params['valor'] != "" ? $queryValor = "b.valor_pago = '" . $number->formatCurrency($this->params['valor']) . "' AND " : $queryValor = "";
        if ($this->params['dataPagamentoInit'] != "" && $this->params['dataPagamentoEnd'] != "") {
            $queryDataPagamento = "b.data_pagamento BETWEEN '" . $data->dataBrasilToDataUSA($this->params['dataPagamentoInit']) . "' AND '" . $data->dataBrasilToDataUSA($this->params['dataPagamentoEnd']) . "' AND ";
        } else {
            $queryDataPagamento = "";
        }
        if ($this->params['dataOperacaoInit'] != "" && $this->params['dataOperacaoEnd'] != "") {
            $queryDataOperacao = "b.data BETWEEN '" . $data->dataBrasilToDataUSA($this->params['dataOperacaoInit']) . " " . $this->params['horaOperacaoInit'] . "' AND '" . $data->dataBrasilToDataUSA($this->params['dataOperacaoEnd']) . " " . $this->params['horaOperacaoEnd'] . "' AND ";
        } else {
            $queryDataOperacao = "";
        }
        $formaPagamento = $this->params['formaPagamento'];
        $user = $this->params['usuario'];

        $query = "(SELECT b.*, u.nome AS userName, t.id AS titulo, t.nosso_numero, fp.descricao AS formaPagamento, t.valor, p.nome, a.matricula FROM baixa b 
                    INNER JOIN usuario u ON u.username = b.user_create
                    INNER JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    INNER JOIN titulo t ON t.id = b.titulo_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                   WHERE t.nosso_numero LIKE '$nossoNumero%' AND
                         p.nome LIKE '$nome%' AND 
                         a.matricula LIKE '$matricula%' AND 
                         " . $queryValor . $queryDataPagamento . $queryDataOperacao . " 
                         fp.id LIKE '$formaPagamento' AND
                         b.user_create LIKE '$user')
                  UNION
                  (SELECT b.*, u.nome AS userName, t.id AS titulo, t.nosso_numero, fp.descricao AS formaPagamento, t.valor, p.nome, a.matricula FROM baixa b 
                    INNER JOIN usuario u ON u.username = b.user_create
                    INNER JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    INNER JOIN titulo t ON t.id = b.titulo_id
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                   WHERE t.nosso_numero LIKE '$nossoNumero%' AND
                         p.nome LIKE '$nome%' AND 
                         a.matricula LIKE '$matricula%' AND 
                         " . $queryValor . $queryDataPagamento . $queryDataOperacao . " 
                         fp.id LIKE '$formaPagamento' AND
                         b.user_create LIKE '$user')";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = array("number" => new Number(), "data" => new Data());
        $this->render($this->action, "result", $arrayRetorno);
    }

    public function _resultReport() {
        $conection = new Conection();
        $data = new Data();
        $arrayData = array();
        $number = new Number();
        $nossoNumero = $this->params['nossoNumero'];
        $nome = $this->params['nome'];
        $matricula = $this->params['matricula'];
        $this->params['valor'] != "" ? $queryValor = "b.valor_pago = '" . $number->formatCurrency($this->params['valor']) . "' AND " : $queryValor = "";
        $arrayData['dataPagamentoInit'] = $this->params['dataPagamentoInit'];
        $arrayData['dataPagamentoEnd'] = $this->params['dataPagamentoEnd'];
        if ($this->params['dataPagamentoInit'] != "" && $this->params['dataPagamentoEnd'] != "") {
            $queryDataPagamento = "b.data_pagamento BETWEEN '" . $data->dataBrasilToDataUSA($this->params['dataPagamentoInit']) . "' AND '" . $data->dataBrasilToDataUSA($this->params['dataPagamentoEnd']) . "' AND ";
        } else {
            $queryDataPagamento = "";
        }
        $arrayData['dataOperacaoInit'] = $this->params['dataOperacaoInit'] . " " . $this->params['horaOperacaoInit'];
        $arrayData['dataOperacaoEnd'] = $this->params['dataOperacaoEnd'] . " " . $this->params['horaOperacaoEnd'];
        if ($this->params['dataOperacaoInit'] != "" && $this->params['dataOperacaoEnd'] != "") {
            $queryDataOperacao = "b.data BETWEEN '" . $data->dataBrasilToDataUSA($this->params['dataOperacaoInit']) . " " . $this->params['horaOperacaoInit'] . "' AND '" . $data->dataBrasilToDataUSA($this->params['dataOperacaoEnd']) . " " . $this->params['horaOperacaoEnd'] . "' AND ";
        } else {
            $queryDataOperacao = "";
        }
        $idFormaPagamento = $this->params['formaPagamento'];
        if ($idFormaPagamento != "%") {
            $formaPagamento = new FormaPagamento();
            $arrayData['formaPagamento'] = $formaPagamento->get($this->params['formaPagamento']);
        } else {
            $arrayData['formaPagamento'] = array('dados' => array("descricao" => "Todas"));
        }

        $idUser = $this->params['usuario'];
        if ($idUser != "%") {
            $user = new User();
            $arrayData['usuario'] = $user->getByUsername($this->params['usuario']);
        } else {
            $arrayData['usuario'] = array('dados' => array("nome" => "Todos"));
        }

        $query = "(SELECT b.*, u.nome AS userName, up.nome AS userNameUpdate, t.id AS titulo, t.nosso_numero, t.valor, fp.descricao AS formaPagamento, t.valor, p.nome, p.cpf, a.matricula FROM baixa b 
                    INNER JOIN usuario u ON u.username = b.user_create
                    LEFT JOIN usuario up ON up.username = b.user_update
                    INNER JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    INNER JOIN titulo t ON t.id = b.titulo_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                   WHERE t.nosso_numero LIKE '$nossoNumero%' AND
                         p.nome LIKE '$nome%' AND 
                         a.matricula LIKE '$matricula%' AND 
                         " . $queryValor . $queryDataPagamento . $queryDataOperacao . " 
                         fp.id LIKE '$idFormaPagamento' AND
                         b.user_create LIKE '$idUser')
                  UNION
                  (SELECT b.*, u.nome AS userName, up.nome AS userNameUpdate, t.id AS titulo, t.nosso_numero, t.valor, fp.descricao AS formaPagamento, t.valor, p.nome, p.cpf, a.matricula FROM baixa b 
                    INNER JOIN usuario u ON u.username = b.user_create
                    LEFT JOIN usuario up ON up.username = b.user_update
                    INNER JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    INNER JOIN titulo t ON t.id = b.titulo_id
                    INNER JOIN aluno a ON a.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                   WHERE t.nosso_numero LIKE '$nossoNumero%' AND
                         p.nome LIKE '$nome%' AND 
                         a.matricula LIKE '$matricula%' AND 
                         " . $queryValor . $queryDataPagamento . $queryDataOperacao . " 
                         fp.id LIKE '$idFormaPagamento' AND
                         b.user_create LIKE '$idUser')";

        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        if ($this->params['type'] == "A") {
            $arrayData['titulo'] = "Relatório de Baixas - Analítico";
            $report = "resultAnalitico";
        } else {
            $arrayData['titulo'] = "Relatório de Baixas - Sintético";
            $report = "resultSintetico";
        }
        $arrayData['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "data" => $data, "number" => $number);
        $this->renderReport($this->action, $report, $arrayData);
    }
    
    public function _resultReportByTurma() {
        $conection = new Conection();
        $data = new Data();
        $arrayData = array();
        $number = new Number();
        $idGrade = $this->params['grade'];
        if ($idGrade != "%") {
            $grade = new Grade();
            $arrayData['grade'] = $grade->get($idGrade);
        } else {
            $arrayData['grade'] = array("dados" => array("codigo" => "", "nome" => "Todas"));
        }
        if (isset($this->params['turma'])) {
            $idTurma = $this->params['turma'];
            if ($idTurma != "%") {
                $turma = new Turma();
                $arrayData["turma"] = $turma->get($idTurma);
            } else {
                $arrayData["turma"] = array("dados" => array("codigo" => "", "observacao" => "Todas"));
            }
        } else {
            $arrayData["turma"] = array("dados" => array("codigo" => "", "observacao" => "Todas"));
            $idTurma = "%";
        }
        $idPeriodo = $this->params['periodo'];
        if ($idPeriodo != "%") {
            $periodo = new Periodo();
            $arrayData['periodo'] = $periodo->get($idPeriodo);
        } else {
            $arrayData['periodo'] = array("dados" => array("codigo" => "Todos"));
        }
        
        $arrayData['dataPagamentoInit'] = $this->params['dataPagamentoInit'];
        $arrayData['dataPagamentoEnd'] = $this->params['dataPagamentoEnd'];
        if ($this->params['dataPagamentoInit'] != "" && $this->params['dataPagamentoEnd'] != "") {
            $queryDataPagamento = "b.data_pagamento BETWEEN '" . $data->dataBrasilToDataUSA($this->params['dataPagamentoInit']) . "' AND '" . $data->dataBrasilToDataUSA($this->params['dataPagamentoEnd']) . "' AND ";
        } else {
            $queryDataPagamento = "";
        }
        
        $idFormaPagamento = $this->params['formaPagamento'];
        if ($idFormaPagamento != "%") {
            $formaPagamento = new FormaPagamento();
            $arrayData['formaPagamento'] = $formaPagamento->get($this->params['formaPagamento']);
        } else {
            $arrayData['formaPagamento'] = array('dados' => array("descricao" => "Todas"));
        }

        $query = "(SELECT b.*, u.nome AS userName, up.nome AS userNameUpdate, t.id AS titulo, t.nosso_numero, t.valor, fp.descricao AS formaPagamento, t.valor, p.nome, p.cpf, a.matricula FROM baixa b 
                    INNER JOIN usuario u ON u.username = b.user_create
                    LEFT JOIN usuario up ON up.username = b.user_update
                    INNER JOIN forma_pagamento fp ON fp.id = b.forma_pagamento_id
                    INNER JOIN titulo t ON t.id = b.titulo_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                   WHERE m.periodo_id LIKE '$idPeriodo' AND
                         m.turma_id LIKE '$idTurma' AND 
                         a.grade_id LIKE '$idGrade' AND 
                         " . $queryDataPagamento . " 
                         fp.id LIKE '$idFormaPagamento')";

        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $arrayData['titulo'] = "Relatório de Baixas por Turma";
        $report = "resultByTurma";
        $arrayData['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "data" => $data, "number" => $number);
        $this->renderReport($this->action, $report, $arrayData);
    }

}

?>
