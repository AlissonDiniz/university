<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MainController
 *
 * @author Alisson
 */
include_once '../../config/Conection.php';
include_once '../config/urlmapping.php';
include_once '../class/Periodo.php';
include_once '../class/Parametro.php';
include_once '../../function/util/Data.php';
include_once '../../function/enum/DiaSemana.php';
include_once '../../lib/zebra_pagination/Zebra_Pagination.php';

class MainController {

    public $class;

    public function _index() {
        $this->_home();
    }

    public function _home() {
        $conection = new Conection();
        $periodo = new Periodo();
        $parametro = new Parametro();
        $arrayParametro = $parametro->get();
        $arrayPeriodo = $periodo->get($arrayParametro['dados']['periodo_atual_id']);
        $data = array();
        $data['periodo'] = $arrayPeriodo['dados'];
        $query = "SELECT COUNT(*) FROM matricula_turma_disciplina mtd
                    INNER JOIN matricula m ON mtd.matricula_id = m.id AND m.periodo_id = '" . $arrayParametro['dados']['periodo_atual_id'] . "' AND m.aluno_id = '" . $_SESSION['id'] . "'";
        $result = $conection->selectQuery($query);
        $arrayData = $conection->fetch($result);
        $data['disciplinas'] = $arrayData[0];
        $diaSemana = new DiaSemana();
        $hoje = date("N");
        $hojeDescricao = "";

        foreach ($diaSemana->loadOpcoes() as $dia) {
            if ($hoje == "7" && $dia['value'] == "01") {
                $hoje = $dia['value'];
                $hojeDescricao = $dia['nome'];
                break;
            } else {
                if ($dia['value'] == "0" . ($hoje + 1)) {
                    $hoje = $dia['value'];
                    $hojeDescricao = $dia['nome'];
                    break;
                }
            }
        }

        $data['hojeDescricao'] = $hojeDescricao;
        $query = "SELECT h.*, d.nome FROM horario h
                    INNER JOIN matricula_turma_disciplina mtd ON mtd.turma_disciplina_id = h.turma_disciplina_id
                    INNER JOIN matricula m ON m.id = mtd.matricula_id AND m.periodo_id = '" . $arrayParametro['dados']['periodo_atual_id'] . "' AND m.aluno_id = '" . $_SESSION['id'] . "'
                    INNER JOIN turma_disciplina td ON td.id = h.turma_disciplina_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    WHERE h.dia = '$hoje'";
        $result = $conection->selectQuery($query);
        $arrayData = $conection->fetch($result);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['horarios'] = $arrayRetorno;

        $query = "SELECT * FROM mensagem WHERE type = 'ALUNO' ORDER BY data DESC LIMIT 10";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['mensagens'] = $arrayRetorno;
        $this->class = array("data" => new Data());
        $this->render($this->action, "index", $data);
    }

    public function redirect($controller, $method, $data) {
        $controller = strtolower(str_replace("Controller", "", $controller));
        $uri = explode("?", $_SERVER['REQUEST_URI']);
        $uri = $uri[0] . "?" . $controller . "/" . $method;
        header("Location: " . $uri . "/" . $data['id']);
    }

    public function render($controller, $method, $data) {
        $uri = explode("?", $_SERVER['REQUEST_URI']);
        $router = explode("/", $uri[1]);
        $uri = $uri[0] . "?" . $router[0] . "/";
        $action = strtolower(str_replace('Controller', '', $controller));
        $classFunction = $this->class;
        include_once '../view/' . $action . '/' . $method . ".php";
    }

    protected function paginate($count) {
        $pagination = new Zebra_Pagination();
        $records_per_page = 12;
        $pagination->records($count);
        $pagination->records_per_page($records_per_page);
        $limit = (($pagination->get_page() - 1) * $records_per_page) . ', ' . $records_per_page;
        return array("limit" => $limit, "pagination" => $pagination);
    }

}

?>
