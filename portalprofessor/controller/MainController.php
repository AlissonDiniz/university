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
include_once '../../function/util/Data.php';
include_once '../class/Parametro.php';
include_once '../class/Periodo.php';
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
        $query = "SELECT COUNT(*) FROM (SELECT td.id FROM horario h
                        INNER JOIN turma_disciplina td ON h.turma_disciplina_id = td.id
                        INNER JOIN turma tu ON tu.id = td.turma_id AND tu.periodo_id = '" . $arrayParametro['dados']['periodo_atual_id'] . "' 
                        WHERE professor_id =  '" . $_SESSION['id'] . "' 
                        GROUP BY td.id) t";
        $result = $conection->selectQuery($query);
        $arrayData = $conection->fetch($result);
        $data['turmas'] = $arrayData[0];

        $query = "SELECT COUNT(*) FROM (SELECT td.id FROM horario h
                        INNER JOIN turma_disciplina td ON h.turma_disciplina_id = td.id
                        INNER JOIN turma tu ON tu.id = td.turma_id AND tu.periodo_id = '" . $arrayParametro['dados']['periodo_atual_id'] . "' 
                        INNER JOIN matricula_turma_disciplina mtd ON mtd.turma_disciplina_id = td.id
                        WHERE professor_id =  '" . $_SESSION['id'] . "'
                        GROUP BY td.id) t";
        $result = $conection->selectQuery($query);
        $arrayData = $conection->fetch($result);
        $data['alunos'] = $arrayData[0];

        $query = "SELECT * FROM mensagem WHERE type = 'PROFESSOR' ORDER BY data DESC LIMIT 10";
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
