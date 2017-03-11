<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FinanceiroController
 *
 * @author Alisson
 */
include_once 'MainController.php';
include_once '../class/Titulo.php';
include_once '../../function/Enum.php';
include_once '../../function/util/Number.php';
include_once '../../function/util/Data.php';
include_once '../../function/enum/SituacaoTitulo.php';
include_once '../../lib/html2pdf-4.0/html2pdf.class.php';

class FinanceiroController extends MainController {

    public $params;

    public function _index() {
        $this->_listTitulos();
    }

    public function _listTitulos() {
        $titulo = new Titulo();
        $data = array();
        $zebraPagination = $this->paginate($titulo->count($_SESSION['id']));
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum(), "situacaoTitulo" => new SituacaoTitulo(), "number" => new Number(), "data" => new Data());
        foreach ($titulo->listarLimit($_SESSION['id'], $zebraPagination['limit']) as $value) {
            if ($value['dados']['situacao'] != "B" && $value['dados']['status'] == "1" && strtotime(date("Y-m-d")) > strtotime($value['dados']['vencimento'])) {
                $value['dados']['situacao'] = "V";
            }
            $data[] = $value;
        }
        $this->render($this->action, "listTitulos", $data);
    }

    public function _showTitulo() {
        $titulo = new Titulo();
        $data = $titulo->get($this->params['id']);
        if ($data['dados']['situacao'] != "B" && $data['dados']['status'] == "1" && strtotime(date("Y-m-d")) > strtotime($data['dados']['vencimento'])) {
            $data['dados']['situacao'] = "V";
        }
        $this->class = array("enum" => new Enum(), "situacaoTitulo" => new SituacaoTitulo(), "number" => new Number(), "data" => new Data());
        $this->render($this->action, "showTitulo", $data);
    }

    public function _reportBoleto() {
        $idTitulo = $this->params['id'];
        $titulo = new Titulo();
        $arrayTitulo = $titulo->get($idTitulo);
        $content = file_get_contents(serviceHttp . "boleto/create?user=" . $_SESSION['username'] . "&nossoNumero=" . $arrayTitulo['dados']['nosso_numero'] . "&idAluno=&periodo=&parcela=&venc=false");
        $Pdf = new HTML2PDF('P', 'A4', 'pt');
        $Pdf->pdf->SetTitle("Boleto Bancario - " . date("ymd"));
        $Pdf->WriteHTML($content, isset($_GET['vuehtml']));
        $Pdf->Output("Boleto Bancario - " . date("ymd") . ".pdf");
    }

}

?>
