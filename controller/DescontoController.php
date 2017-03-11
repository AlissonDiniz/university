<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DescontoController
 *
 * @author Alisson
 */
include_once '../class/Desconto.php';
include_once '../class/Titulo.php';
include_once '../class/Turma.php';
include_once '../class/TipoDesconto.php';
include_once '../class/Matricula.php';
include_once '../class/Grade.php';
include_once '../class/Periodo.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/util/Number.php';
include_once '../function/enum/Numbers.php';
include_once '../function/util/Data.php';
include_once '../function/enum/SituacaoTitulo.php';
include_once '../function/enum/SituacaoPeriodo.php';

class DescontoController extends MainController {

    public $action;
    public $method;
    public $params;

    public function DescontoController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_listByTitulo", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_createByTitulo", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_createByMatricula", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_getMatricula", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_showByTitulo", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_editByTitulo", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_report", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVEBYTITULO", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATEBYTITULO", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETEBYTITULO", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_result", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_resultReport", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $tipoDesconto = new TipoDesconto();
        $arrayTipoDesconto = $tipoDesconto->listar();
        $array = array();
        foreach ($arrayTipoDesconto as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['tipoDesconto'] = $array;
        $desconto = new Desconto();
        $zebraPagination = $this->paginate($desconto->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum(), "number" => new Number());
        $data['descontos'] = $desconto->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _listByTitulo() {
        $tipoDesconto = new TipoDesconto();
        $arrayTipoDesconto = $tipoDesconto->listar();
        $array = array();
        foreach ($arrayTipoDesconto as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['tipoDesconto'] = $array;
        $desconto = new Desconto();
        $titulo = new Titulo();
        $arrayTitulo = $titulo->get($this->params['id']);
        $data['titulo'] = $arrayTitulo['dados'];
        $this->class = array("enum" => new Enum(), "number" => new Number());
        $data['descontos'] = $desconto->listarByTitulo($arrayTitulo['dados']['id']);
        $this->render($this->action, "listByTitulo", $data);
    }

    public function _create() {
        $this->render($this->action, "create", null);
    }

    public function _createByTitulo() {
        $tipoDesconto = new TipoDesconto();
        $arrayTipoDesconto = $tipoDesconto->listar();
        $array = array();
        foreach ($arrayTipoDesconto as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['tipoDesconto'] = $array;
        $titulo = new Titulo();
        $arrayTitulo = $titulo->get($this->params['id']);
        $data['titulo'] = $arrayTitulo['dados'];
        $this->class = array('funcoesHTML' => new FuncoesHTML());
        $this->render($this->action, "createByTitulo", $data);
    }

    public function _createByMatricula() {
        $tipoDesconto = new TipoDesconto();
        $arrayTipoDesconto = $tipoDesconto->listar();
        $array = array();
        foreach ($arrayTipoDesconto as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['tipoDesconto'] = $array;
        $matricula = new Matricula();
        $titulo = new Titulo();
        $array = $matricula->get($this->params['id']);
        $data['matricula'] = $array['dados'];
        $arrayTitulos = array();
        foreach ($titulo->listarByMatricula($data['matricula']['id']) as $tituloInstance) {
            if ($tituloInstance['dados']['situacao'] != 'B') {
                $arrayTitulos [] = $tituloInstance;
            }
        }
        $data['titulos'] = $arrayTitulos;
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "situacaoTitulo" => new SituacaoTitulo(), 'enum' => new Enum(), "number" => new Number, "data" => new Data());
        $this->render($this->action, "createByMatricula", $data);
    }

    public function _getMatricula() {
        $matricula = new Matricula();
        $enum = new Enum();
        $situacaoPeriodo = new SituacaoPeriodo();
        foreach ($matricula->getToAluno($this->params['aluno']) as $matricula) {
            ?>
            <tr>
                <td width="20">
                    <a href="<?= application ?>desconto/createByMatricula/<?php echo $matricula['dados']['id']; ?>">
                        <img alt="" src="<?= image ?>icons/application_add.png" />
                    </a>
                </td>
                <td width="120"><?php echo $matricula['dados']['periodo']; ?></td>
                <td width="60"><?php echo $matricula['dados']['matricula']; ?></td>
                <td width="400" style="text-align: left"><?php echo $matricula['dados']['nome']; ?></td>
                <td width="100"><?php echo $enum->enumOpcoes($matricula['dados']['situacao'], $situacaoPeriodo->loadOpcoes()); ?></td>
                <td width="60" style="border-right: none"><?php echo $enum->enumStatus($matricula['dados']['status']); ?></td>
            </tr>
            <?
        }
    }

    public function _show() {
        $desconto = new Desconto();
        $data = $desconto->get($this->params['id']);
        $this->class = array("enum" => new Enum(), "number" => new Number());
        $this->render($this->action, "show", $data);
    }

    public function _showByTitulo() {
        $desconto = new Desconto();
        $data = $desconto->get($this->params['id']);
        $this->class = array("enum" => new Enum(), "number" => new Number());
        $this->render($this->action, "showByTitulo", $data);
    }

    public function _editByTitulo() {
        $tipoDesconto = new TipoDesconto();
        $arrayTipoDesconto = $tipoDesconto->listar();
        $array = array();
        foreach ($arrayTipoDesconto as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['tipoDesconto'] = $array;
        $desconto = new Desconto();
        $data['desconto'] = $desconto->get($this->params['id']);
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum(), "number" => new Number());
        $this->render($this->action, "editByTitulo", $data);
    }

    public function _edit() {
        $tipoDesconto = new TipoDesconto();
        $arrayTipoDesconto = $tipoDesconto->listar();
        $array = array();
        foreach ($arrayTipoDesconto as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['tipoDesconto'] = $array;
        $desconto = new Desconto();
        $data['desconto'] = $desconto->get($this->params['id']);
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum(), "number" => new Number());
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
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
        $tipoDesconto = new TipoDesconto();
        $arrayTipoDesconto = $tipoDesconto->listar();
        $array = array();
        foreach ($arrayTipoDesconto as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['tipoDesconto'] = $array;
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum(), "numbers" => new Numbers());
        $this->render($this->action, "search", $data);
    }

    public function _report() {
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
        $tipoDesconto = new TipoDesconto();
        $arrayTipoDesconto = $tipoDesconto->listar();
        $array = array();
        foreach ($arrayTipoDesconto as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['tipoDesconto'] = $array;
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum(), "numbers" => new Numbers());
        $this->render($this->action, "report", $data);
    }

    public function _SAVEBYTITULO() {
        $desconto = new Desconto();
        $number = new Number();
        $this->params['valor'] = $number->formatCurrency($this->params['valor']);
        $titulo = new Titulo();
        $array = $titulo->get($this->params['titulo']);
        $paramsTitulo = $array['dados'];
        if ($paramsTitulo['valor_restante'] < $this->params['valor']) {
            $_SESSION['error'] = "O Valor do desconto é maior que o valor restante do Título!";
            $this->redirect($this->action, "createByTitulo", array("id" => $this->params['titulo']));
            return;
        } else {
            $tipoDesconto = new TipoDesconto();
            $arrayTipoDesconto = $tipoDesconto->get($this->params['tipoDesconto']);
            $arrayType = explode("-", $arrayTipoDesconto['dados']['type']);
            if ($arrayType[1] == "1" && $this->params['status'] == '1') {
                $paramsTitulo['valor_restante'] = $paramsTitulo['valor_restante'] - $this->params['valor'];
            }
            $paramsTitulo['configuracao'] = $paramsTitulo['configuracao_id'];
            if (!$titulo->update($paramsTitulo)) {
                $_SESSION['error'] = "Ocorreu um erro ao alterar o Título!";
                $this->redirect($this->action, "createByTitulo", array("id" => $this->params['titulo']));
            } else {
                $this->params['idTitulo'] = $this->params['titulo'];
                if ($desconto->save($this->params)) {
                    $_SESSION['flash'] = "Desconto salvo com Sucesso!";
                    $this->redirect($this->action, "listByTitulo", array("id" => $paramsTitulo['id']));
                } else {
                    $_SESSION['error'] = "Ocorreu um erro ao salvar o Desconto!";
                    $this->redirect($this->action, "createByTitulo", array("id" => $this->params['titulo']));
                    return;
                }
            }
        }
    }

    public function _SAVE() {
        $desconto = new Desconto();
        $titulo = new Titulo();
        $number = new Number();
        $this->params['valor'] = $number->formatCurrency($this->params['valor']);
        foreach ($this->params['titulos'] as $idTitulo) {
            $array = $titulo->get($idTitulo);
            $paramsTitulo = $array['dados'];
            if ($paramsTitulo['valor_restante'] < $this->params['valor']) {
                $_SESSION['error'] = "O Valor do desconto é maior que o valor do Título!";
                $this->redirect($this->action, "create", null);
                return;
            } else {
                $tipoDesconto = new TipoDesconto();
                $arrayTipoDesconto = $tipoDesconto->get($this->params['tipoDesconto']);
                $arrayType = explode("-", $arrayTipoDesconto['dados']['type']);
                if ($arrayType[1] == "1" && $this->params['status'] == '1') {
                    $paramsTitulo['valor_restante'] = $paramsTitulo['valor_restante'] - $this->params['valor'];
                }

                $paramsTitulo['configuracao'] = $paramsTitulo['configuracao_id'];
                if (!$titulo->update($paramsTitulo)) {
                    $_SESSION['error'] = "Ocorreu um erro ao salvar o Desconto!";
                    $this->redirect($this->action, "create", null);
                    return;
                } else {
                    $this->params['idTitulo'] = $idTitulo;
                    if ($desconto->save($this->params)) {
                        $_SESSION['flash'] = "Desconto salvo com Sucesso!";
                        $this->redirect($this->action, "list", null);
                    } else {
                        $_SESSION['error'] = "Ocorreu um erro ao salvar o Desconto!";
                        $this->redirect($this->action, "create", null);
                        return;
                    }
                }
            }
        }
    }

    public function _UPDATEBYTITULO() {
        $desconto = new Desconto();
        $array = $desconto->get($this->params['id']);
        $arrayDesconto = $array['dados'];

        $number = new Number();
        $this->params['valor'] = $number->formatCurrency($this->params['valor']);

        $titulo = new Titulo();
        $array = $titulo->get($arrayDesconto['titulo_id']);
        $paramsTitulo = $array['dados'];

        if ($paramsTitulo['valor_restante'] < ($this->params['valor'] - $arrayDesconto['valor'])) {
            $_SESSION['error'] = "O Valor do desconto é maior que o valor do Título!";
            $this->redirect($this->action, "listByTitulo", array("id" => $paramsTitulo['id']));
            die();
        } else {

            $tipoDesconto = new TipoDesconto();
            $arrayTipoDesconto = $tipoDesconto->get($arrayDesconto['tipo_desconto_id']);
            $arrayType = explode("-", $arrayTipoDesconto['dados']['type']);

            if ($arrayType[1] == "1" && $arrayDesconto['status'] == "1") {
                $arrayTipoDescontoNew = $tipoDesconto->get($this->params['tipoDesconto']);
                $arrayTypeNew = explode("-", $arrayTipoDescontoNew['dados']['type']);
                if ($arrayTypeNew[1] == "1" && $this->params['status'] == '1') {
                    $paramsTitulo['valor_restante'] = $paramsTitulo['valor_restante'] - ($this->params['valor'] - $arrayDesconto['valor']);
                } else {
                    $paramsTitulo['valor_restante'] = $paramsTitulo['valor_restante'] + $arrayDesconto['valor'];
                }
            } else {
                $arrayTipoDescontoNew = $tipoDesconto->get($this->params['tipoDesconto']);
                $arrayTypeNew = explode("-", $arrayTipoDescontoNew['dados']['type']);
                if ($arrayTypeNew[1] == "1" && $this->params['status'] == '1') {
                    $paramsTitulo['valor_restante'] = $paramsTitulo['valor_restante'] - $this->params['valor'];
                }
            }

            $paramsTitulo['configuracao'] = $paramsTitulo['configuracao_id'];
            if (!$titulo->update($paramsTitulo)) {
                $_SESSION['error'] = "Ocorreu um erro ao editar o Desconto!";
                $this->redirect($this->action, "listByTitulo", array("id" => $paramsTitulo['id']));
            } else {
                if ($desconto->update($this->params)) {
                    $_SESSION['flash'] = "Desconto editado com Sucesso!";
                    $this->redirect($this->action, "listByTitulo", array("id" => $paramsTitulo['id']));
                } else {
                    $_SESSION['error'] = "Ocorreu um erro ao editar o Desconto!";
                    $this->redirect($this->action, "listByTitulo", array("id" => $paramsTitulo['id']));
                    return;
                }
            }
        }
    }

    public function _UPDATE() {
        $desconto = new Desconto();
        $array = $desconto->get($this->params['id']);
        $arrayDesconto = $array['dados'];
        $number = new Number();
        $this->params['valor'] = $number->formatCurrency($this->params['valor']);

        $titulo = new Titulo();
        $array = $titulo->get($arrayDesconto['titulo_id']);
        $paramsTitulo = $array['dados'];

        if ($paramsTitulo['valor_restante'] < ($this->params['valor'] - $arrayDesconto['valor'])) {
            $_SESSION['error'] = "O Valor do desconto é maior que o valor do Título!";
            $this->redirect($this->action, "list", null);
            die();
        } else {

            $tipoDesconto = new TipoDesconto();
            $arrayTipoDesconto = $tipoDesconto->get($arrayDesconto['tipo_desconto_id']);
            $arrayType = explode("-", $arrayTipoDesconto['dados']['type']);

            if ($arrayType[1] == "1" && $arrayDesconto['status'] == "1") {
                $arrayTipoDescontoNew = $tipoDesconto->get($this->params['tipoDesconto']);
                $arrayTypeNew = explode("-", $arrayTipoDescontoNew['dados']['type']);
                if ($arrayTypeNew[1] == "1" && $this->params['status'] == '1') {
                    $paramsTitulo['valor_restante'] = $paramsTitulo['valor_restante'] - ($this->params['valor'] - $arrayDesconto['valor']);
                } else {
                    $paramsTitulo['valor_restante'] = $paramsTitulo['valor_restante'] + $arrayDesconto['valor'];
                }
            } else {
                $arrayTipoDescontoNew = $tipoDesconto->get($this->params['tipoDesconto']);
                $arrayTypeNew = explode("-", $arrayTipoDescontoNew['dados']['type']);
                if ($arrayTypeNew[1] == "1" && $this->params['status'] == '1') {
                    $paramsTitulo['valor_restante'] = $paramsTitulo['valor_restante'] - $this->params['valor'];
                }
            }

            $paramsTitulo['configuracao'] = $paramsTitulo['configuracao_id'];
            if (!$titulo->update($paramsTitulo)) {
                $_SESSION['error'] = "Ocorreu um erro ao editar o Desconto!";
                $this->redirect($this->action, "list", null);
            } else {
                if ($desconto->update($this->params)) {
                    $_SESSION['flash'] = "Desconto editado com Sucesso!";
                    $this->redirect($this->action, "list", null);
                } else {
                    $_SESSION['error'] = "Ocorreu um erro ao editar o Desconto!";
                    $this->redirect($this->action, "list", null);
                    return;
                }
            }
        }
    }

    public function _DELETEBYTITULO() {
        $desconto = new Desconto();
        $array = $desconto->get($this->params['id']);
        $arrayDesconto = $array['dados'];
        $titulo = new Titulo();
        $array = $titulo->get($arrayDesconto['titulo_id']);
        $paramsTitulo = $array['dados'];
        $tipoDesconto = new TipoDesconto();
        $arrayTipoDesconto = $tipoDesconto->get($arrayDesconto['tipo_desconto_id']);
        $arrayType = explode("-", $arrayTipoDesconto['dados']['type']);
        if ($arrayType[1] == "1" && $arrayDesconto['status'] == '1') {
            $paramsTitulo['valor_restante'] = $paramsTitulo['valor_restante'] + $arrayDesconto['valor'];
        }
        $paramsTitulo['configuracao'] = $paramsTitulo['configuracao_id'];

        if (!$titulo->update($paramsTitulo)) {
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Título!";
            $this->redirect($this->action, "listByTitulo", array("id" => $arrayDesconto['titulo_id']));
        } else {
            if ($desconto->delete($this->params)) {
                $_SESSION['flash'] = "Desconto deletado com Sucesso!";
                $this->redirect($this->action, "listByTitulo", array("id" => $arrayDesconto['titulo_id']));
            } else {
                $_SESSION['error'] = "Ocorreu um erro ao deletar o Desconto!";
                $this->redirect($this->action, "listByTitulo", array("id" => $arrayDesconto['titulo_id']));
            }
        }
    }

    public function _DELETE() {
        $desconto = new Desconto();
        $array = $desconto->get($this->params['id']);
        $arrayDesconto = $array['dados'];
        $titulo = new Titulo();
        $array = $titulo->get($arrayDesconto['titulo_id']);
        $paramsTitulo = $array['dados'];
        $tipoDesconto = new TipoDesconto();
        $arrayTipoDesconto = $tipoDesconto->get($arrayDesconto['tipo_desconto_id']);
        $arrayType = explode("-", $arrayTipoDesconto['dados']['type']);
        if ($arrayType[1] == "1" && $arrayDesconto['status'] == '1') {
            $paramsTitulo['valor_restante'] = $paramsTitulo['valor_restante'] + $arrayDesconto['valor'];
        }
        $paramsTitulo['configuracao'] = $paramsTitulo['configuracao_id'];
        if (!$titulo->update($paramsTitulo)) {
            $_SESSION['error'] = "Ocorreu um erro ao deletar o Desconto!";
            $this->redirect($this->action, "list", null);
        } else {
            if ($desconto->delete($this->params)) {
                $_SESSION['flash'] = "Desconto deletado com Sucesso!";
                $this->redirect($this->action, "list", null);
            } else {
                $_SESSION['error'] = "Ocorreu um erro ao deletar o Desconto!";
                $this->redirect($this->action, "list", null);
            }
        }
    }

    public function _result() {
        $conection = new Conection();
        $grade = $this->params['grade'];
        if (isset($this->params['turma'])) {
            $turma = $this->params['turma'];
        } else {
            $turma = "%";
        }
        $nossoNumero = $this->params['nossoNumero'];
        $matricula = $this->params['matricula'];
        $tipoDesconto = $this->params['tipoDesconto'];
        $nome = $this->params['nome'];
        $periodo = $this->params['periodo'];
        $valor = "";
        if ($this->params['valor'] != "") {
            $valor = "d.valor = '" . $this->params['valor'] . "' AND";
        }
        $parcela = $this->params['parcela'];
        $status = $this->params['status'];
        $query = "(SELECT d.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, td.descricao AS tipoDesconto, pa.numero AS parcela FROM desconto d
                    INNER JOIN tipo_desconto td ON td.id = d.tipo_desconto_id
                    INNER JOIN titulo t ON t.id = d.titulo_id
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno al ON al.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                    INNER JOIN grade g ON g.id = al.grade_id
                    WHERE p.nome LIKE '$nome%' AND
                          al.matricula LIKE '$matricula%' AND 
                          t.nosso_numero LIKE '$nossoNumero%' AND
                          pa.numero LIKE '$parcela' AND 
                          m.periodo_id LIKE '$periodo' AND 
                          m.turma_id LIKE '$turma' AND
                          g.id LIKE '$grade' AND
                          d.tipo_desconto_id LIKE '$tipoDesconto' AND
                          " . $valor . " 
                          d.status LIKE '$status')";
        
        if($periodo == "%"){
            $query = $query . "UNION
                                (SELECT d.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, td.descricao AS tipoDesconto, '-' AS parcela FROM desconto d
                                  INNER JOIN tipo_desconto td ON td.id = d.tipo_desconto_id
                                  INNER JOIN titulo t ON t.id = d.titulo_id
                                  INNER JOIN aluno al ON al.id = t.aluno_id
                                  INNER JOIN pessoa p ON p.id = al.pessoa_id
                                  WHERE p.nome LIKE '$nome%' AND
                                        al.matricula LIKE '$matricula%' AND 
                                        t.nosso_numero LIKE '$nossoNumero%' AND
                                        d.tipo_desconto_id LIKE '$tipoDesconto' AND
                                        " . $valor . " 
                                        d.status LIKE '$status')";
        }
        
        $query = $query . " ORDER BY matricula, parcela, nosso_numero";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = array("enum" => new Enum(), "number" => new Number());
        $this->render($this->action, "result", $arrayRetorno);
    }

    public function _resultReport() {
        $conection = new Conection();
        $periodo = new Periodo();
        $idGrade = $this->params['grade'];
        if ($idGrade != "%") {
            $grade = new Grade();
            $data['grade'] = $grade->get($idGrade);
        } else {
            $data['grade'] = array("dados" => array("codigo" => "", "nome" => "Todas"));
        }
        if (isset($this->params['turma'])) {
            $idTurma = $this->params['turma'];
            if ($idTurma != "%") {
                $turma = new Turma();
                $data["turma"] = $turma->get($idTurma);
            } else {
                $data["turma"] = array("dados" => array("codigo" => "", "observacao" => "Todas"));
            }
        } else {
            $data["turma"] = array("dados" => array("codigo" => "", "observacao" => "Todas"));
            $idTurma = "%";
        }
        $periodoParam = $this->params['periodo'];
        $nossoNumero = $this->params['nossoNumero'];
        $matricula = $this->params['matricula'];
        $idTipoDesconto = $this->params['tipoDesconto'];
        if ($idTipoDesconto != "%") {
            $tipoDesconto = new TipoDesconto();
            $data['tipoDesconto'] = $tipoDesconto->get($idTipoDesconto);
        } else {
            $data['tipoDesconto'] = array("dados" => array("descricao" => "Todos"));
        }
        $nome = $this->params['nome'];
        $valor = "";
        if ($this->params['valor'] != "") {
            $valor = "d.valor = '" . $this->params['valor'] . "' AND";
        }
        $parcela = $this->params['parcela'];
        if ($parcela != "%") {
            $data['parcela'] = $parcela;
        } else {
            $data['parcela'] = "Todas";
        }
        $status = $this->params['status'];
        $query = "(SELECT d.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, td.descricao AS tipoDesconto, pa.numero AS parcela FROM desconto d
                    INNER JOIN tipo_desconto td ON td.id = d.tipo_desconto_id
                    INNER JOIN titulo t ON t.id = d.titulo_id
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno al ON al.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                    INNER JOIN grade g ON g.id = al.grade_id
                    WHERE p.nome LIKE '$nome%' AND
                          al.matricula LIKE '$matricula%' AND 
                          t.nosso_numero LIKE '$nossoNumero%' AND
                          pa.numero LIKE '$parcela' AND 
                          m.periodo_id LIKE '$periodoParam' AND 
                          m.turma_id LIKE '$idTurma' AND
                          g.id LIKE '$idGrade' AND 
                          d.tipo_desconto_id LIKE '$idTipoDesconto' AND
                          " . $valor . " 
                          d.status LIKE '$status')";
        
        if($periodoParam == "%"){
            $query = $query . "UNION
                                (SELECT d.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, td.descricao AS tipoDesconto, '-' AS parcela FROM desconto d
                                  INNER JOIN tipo_desconto td ON td.id = d.tipo_desconto_id
                                  INNER JOIN titulo t ON t.id = d.titulo_id
                                  INNER JOIN aluno al ON al.id = t.aluno_id
                                  INNER JOIN pessoa p ON p.id = al.pessoa_id
                                  WHERE p.nome LIKE '$nome%' AND
                                        al.matricula LIKE '$matricula%' AND 
                                        t.nosso_numero LIKE '$nossoNumero%' AND
                                        d.tipo_desconto_id LIKE '$idTipoDesconto' AND
                                        " . $valor . " 
                                        d.status LIKE '$status')";
            $data['periodo'] = "Todos";
        }else{
            $arrayPeriodo  = $periodo->get($periodoParam);
            $data['periodo'] = $arrayPeriodo['dados']['codigo'];
        }
        $query = $query . " ORDER BY matricula, parcela, nosso_numero";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['titulo'] = "Relatório de Descontos";
        $data['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "number" => new Number());
        $this->renderReport($this->action, "result", $data);
    }

}
?>
