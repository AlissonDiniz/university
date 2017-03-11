<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuditoriaController
 *
 * @author Alisson
 */
include_once '../class/User.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/util/Data.php';
include_once '../function/FuncoesHTML.php';

class AuditoriaController extends MainController {

    public function AuditoriaController() {
        $this->authorityMethod[] = array("name" => "_logs", "authority" => 4);
    }

    public function _logs() {
        $user = new User();
        $arrayUser = $user->listar();
        $array = array();
        foreach ($arrayUser as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['username']);
        }
        $data['users'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML());
        $this->render($this->action, "logs", $data);
    }

    public function _resultReportLogs() {
        $conection = new Conection();
        $data = new Data();

        $formaOperacao = $this->params['formaOperacao'];
        $metaDado = $this->params['metaDado'];
        $user = $this->params['user'];

        $dataInicial = $data->dataBrasilToDataUSA($this->params['dataInicial']);
        $horaInicial = $this->params['horaInicial'];
        $dataFinal = $data->dataBrasilToDataUSA($this->params['dataFinal']);
        $horaFinal = $this->params['horaFinal'];

        $data = array();
        $arrayRetorno = array();
        
        if ($formaOperacao != "rotina") {
            $query = "SELECT * FROM log_$formaOperacao 
                        WHERE user LIKE '$user' AND
                              query LIKE '%$metaDado%' AND
                              data BETWEEN '$dataInicial $horaInicial' AND '$dataFinal $horaFinal'
                        ORDER BY data DESC";
            $data['operacao'] = "query";
        } else {
            $query = "SELECT * FROM log_rotina 
                        WHERE user LIKE '$user' AND
                              rotina LIKE '%$metaDado%' AND
                              data BETWEEN '$dataInicial $horaInicial' AND '$dataFinal $horaFinal'
                        ORDER BY data DESC";
            $data['operacao'] = "rotina";
        }
        $result = $conection->selectQuery($query);
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['titulo'] = "Relatório - Auditoria de Operações no Sistema";
        $data['result'] = $arrayRetorno;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "data" => new Data());
        $this->renderReport($this->action, "resultLogs", $data);
    }

}

?>
