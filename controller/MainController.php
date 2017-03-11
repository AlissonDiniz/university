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
include_once '../lib/zebra_pagination/Zebra_Pagination.php';

class MainController {

    public $authorityMethod = array();
    public $class;

    public function MainController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 2);
    }

    public function getAuthority($method) {
        foreach ($this->authorityMethod as $value) {
            if ($value['name'] == $method) {
                return $value['authority'];
                break;
            }
        }
        return 10;
    }

    public function _denied() {
        include_once '../view/main/denied.php';
    }

    public function _index() {
        include_once '../config/security.php';
        include_once '../config/Conection.php';
        include_once '../class/Parametro.php';
        include_once '../function/Enum.php';
        include_once '../function/enum/SituacaoPeriodo.php';
        $parametro = new Parametro();
        $data['parametro'] = $parametro->get();
        $conection = new Conection();
        $query = "SELECT
                    COUNT(*) AS matriculas,
                    situacao
                    FROM matricula
                    WHERE periodo_id = '" . $data['parametro']['dados']['periodo_matricula_id'] . "'
                    GROUP BY situacao";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['matriculas'] = $arrayRetorno;
        $query = "SELECT COUNT(m.id) AS matriculas, p.sexo FROM matricula m
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    WHERE m.periodo_id = '" . $data['parametro']['dados']['periodo_matricula_id'] . "'
                    GROUP BY p.sexo";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['alunos'] = $arrayRetorno;
        $query = "SELECT
                    SUM(valor_restante) AS valor, MONTH(vencimento) AS mes
                    FROM titulo
                    WHERE situacao IN ('A', 'P') AND (vencimento BETWEEN '" . date("Y") . "-01-01' AND NOW())
                    GROUP BY mes";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['inadimplencia'] = $this->createArrayChartBar($arrayRetorno);
        $this->class = array("enum" => new Enum(), "situacaoPeriodo" => new SituacaoPeriodo());
        $this->render($this->action, "index", $data);
    }

    private function createArrayChartBar($arrayRetorno) {
        $array = array();
        for ($index = 1; $index < 13; $index++) {
            $valor = 0;
            foreach ($arrayRetorno as $value) {
                if ($value['dados']['mes'] == $index) {
                    $valor = $value['dados']['valor'];
                }
            }
            $array[$index] = $valor;
        }
        return $array;
    }

    private function createRecentsAccess($conection) {
        $query = "SELECT rotina FROM log_rotina
                    WHERE user = '" . $_SESSION['username'] . "'
                    GROUP BY rotina, user
                    ORDER BY data DESC LIMIT 1000";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayUrl = explode("?", $array['rotina']);
            if (count($arrayUrl) > 1) {
                $arrayRotina = explode("/", $arrayUrl[1]);
                if (count($arrayRotina) > 0) {
                    if (strlen($arrayRotina[0]) < 21) {
                        $isNotAdded = true;
                        foreach ($arrayRetorno as $value) {
                            if ($value['dados'] == $arrayRotina[0] || $arrayRotina[0] == "" || strpos($arrayRotina[0], "&") == true) {
                                $isNotAdded = false;
                            }
                        }
                        if ($isNotAdded) {
                            $arrayRetorno[] = array("dados" => $arrayRotina[0]);
                        }
                    }
                }
            }
        }
        $arrayRotinas = array();
        foreach ($arrayRetorno as $value) {
            $rotina = $this->getLinkOption($value["dados"]);
            if ($rotina != "") {
                $arrayRotinas[] = array("dados" => $rotina);
            }
        }
        return $arrayRotinas;
    }

    private function getLinkOption($option) {
        $menuFile = fopen("../view/layout/menu.php", "r");
        $rotina = "";
        while (!feof($menuFile)) {
            $linha = fgets($menuFile);
            if (strpos($linha, '<h2><a href="<?= application ?>') == true) {
                $arrayMenuLine = explode("><img", $linha);
                $arrayMenuLineOption = explode("<?= application ?>", $arrayMenuLine[0]);
                $optionLink = str_replace('"', "", $arrayMenuLineOption[1]);
                $optionLink = str_replace(' ', "", $optionLink);
                if ($optionLink == $option) {
                    $rotina = str_replace("<h2>", "", $linha);
                    $rotina = str_replace("</h2>", "", $rotina);
                    $rotina = str_replace("<?= application ?>", application, $rotina);
                    $rotina = str_replace("<?= image ?>", image, $rotina);
                }
            }
        }
        fclose($menuFile);
        return $rotina;
    }

    public function redirect($controller, $method, $data) {
        $controller = lcfirst(str_replace("Controller", "", $controller));
        $uri = explode("?", $_SERVER['REQUEST_URI']);
        $uri = $uri[0] . "?" . $controller . "/" . $method;
        header("Location: " . $uri . "/" . $data['id']);
    }

    public function render($controller, $method, $data) {
        $uri = explode("?", $_SERVER['REQUEST_URI']);
        $router = explode("/", $uri[1]);
        $uri = $uri[0] . "?" . $router[0] . "/";
        $action = lcfirst(str_replace('Controller', '', $controller));
        $classFunction = $this->class;
        include_once '../view/' . $action . '/' . $method . ".php";
    }

    public function renderReport($controller, $method, $data) {
        $uri = explode("?", $_SERVER['REQUEST_URI']);
        $router = explode("/", $uri[1]);
        $uri = $uri[0] . "?" . $router[0] . "/";
        $action = lcfirst(str_replace('Controller', '', $controller));
        $classFunction = $this->class;
        include_once '../report/' . $action . '/' . $method . ".php";
    }

    protected function createKey() {
        return base64_encode(md5(date("Ymd") . "AUTHENTICATED"));
    }

    protected function paginate($count) {
        $pagination = new Zebra_Pagination();
        $records_per_page = 12;
        $pagination->records($count);
        $pagination->records_per_page($records_per_page);
        $limit = (($pagination->get_page() - 1) * $records_per_page) . ', ' . $records_per_page;
        return array("limit" => $limit, "pagination" => $pagination);
    }

    public function download($uriFile) {
        if (file_exists($uriFile)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($uriFile));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($uriFile));
            ob_clean();
            flush();
            readfile($uriFile);
            exit;
        }
    }

}

?>
