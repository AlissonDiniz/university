<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BoletoController
 *
 * @author Alisson
 */
include_once '../class/Parametro.php';
include_once '../class/Periodo.php';
include_once '../class/Titulo.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/enum/Numbers.php';
include_once '../function/util/Data.php';
include_once '../lib/html2pdf-4.0/html2pdf.class.php';

class BoletoController extends MainController {

    public $action;
    public $method;
    public $params;

    public function BoletoController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_report", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_reportByTitulo", "authority" => 4);
    }

    public function _index() {
        $this->_create();
    }

    public function _create() {
        $parametro = new Parametro();
        $periodo = new Periodo();
        $arrayPeriodos = $periodo->listar();
        $array = array();
        foreach ($arrayPeriodos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $data['parametros'] = $parametro->get();
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "numbers" => new Numbers());
        $this->render($this->action, "create", $data);
    }

    public function _report() {
        $functionHtml = new FuncoesHTML();
        $nossoNumero = $this->params['nossoNumero'];
        $aluno = $this->params['idAluno'];
        $periodo = $this->params['periodo'];
        $parcela = $this->params['parcela'];

        $titulo = new Titulo();
        if ($nossoNumero != "") {
            $arrayTitulo = $titulo->findByNossoNumero($nossoNumero);
        } else {
            $arrayTitulo = $titulo->findByAlunoParcela($aluno, $parcela, $periodo);
        }

        if (count($arrayTitulo) > 0) {
            $vencimentoHoje = "false";
            if (!empty($this->params['vencimentoHoje']) && $this->params['vencimentoHoje'] == "on") {
                $vencimentoHoje = "true";
            }
            $content = $functionHtml->getHTML(
                    serviceHttp . "boleto/create?user=" .
                    $_SESSION['username'] . "&nossoNumero=" .
                    $nossoNumero . "&idAluno=" .
                    $aluno . "&periodo=" .
                    $periodo . "&parcela=" .
                    $parcela . "&venc=" .
                    $vencimentoHoje);
            $Pdf = new HTML2PDF('P', 'A4', 'pt');
            $Pdf->pdf->SetTitle("Boleto Bancario - " . date("ymd"));
            $Pdf->WriteHTML($content, isset($_GET['vuehtml']));
            $Pdf->Output("Boleto Bancario - " . date("ymd") . ".pdf");
        } else {
            $_SESSION['error'] = "Dados do boleto não encontrados!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _reportByTitulo() {
        $functionHtml = new FuncoesHTML();
        $content = $functionHtml->getHTML(serviceHttp . "boleto/create?user=" . $_SESSION['username'] . "&idTitulo=" . $this->params['id']);
        $Pdf = new HTML2PDF('P', 'A4', 'pt');
        $Pdf->pdf->SetTitle("Boleto Bancario - " . date("ymd"));
        $Pdf->WriteHTML($content, isset($_GET['vuehtml']));
        $Pdf->Output("Boleto Bancario - " . date("ymd") . ".pdf");
    }
    
    public function _reportByLote() {
        $functionHtml = new FuncoesHTML();
        $content = $functionHtml->getHTML(serviceHttp . "boleto/createLote?user=" . $_SESSION['username'] . "&ids=" . $this->params['ids']);
        $Pdf = new HTML2PDF('P', 'A4', 'pt');
        $Pdf->pdf->SetTitle("Boletos Bancarios - " . date("ymd"));
        $Pdf->WriteHTML($content, isset($_GET['vuehtml']));
        $Pdf->Output("Boletos Bancarios- " . date("ymd") . ".pdf");
    }

}

?>
