<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AcrescimoController
 *
 * @author Alisson
 */
include_once '../class/Acrescimo.php';
include_once '../class/Titulo.php';
include_once '../class/Turma.php';
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

class AcrescimoController extends MainController {

    public $action;
    public $method;
    public $params;

    public function AcrescimoController() {
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
        $acrescimo = new Acrescimo();
        $zebraPagination = $this->paginate($acrescimo->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum(), "number" => new Number());
        $data = $acrescimo->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _listByTitulo() {
        $acrescimo = new Acrescimo();
        $titulo = new Titulo();
        $arrayTitulo = $titulo->get($this->params['id']);
        $data['titulo'] = $arrayTitulo['dados'];
        $this->class = array("enum" => new Enum(), "number" => new Number());
        $data['acrescimos'] = $acrescimo->listarByTitulo($arrayTitulo['dados']['id']);
        $this->render($this->action, "listByTitulo", $data);
    }

    public function _create() {
        $this->render($this->action, "create", null);
    }

    public function _createByTitulo() {
        $titulo = new Titulo();
        $arrayTitulo = $titulo->get($this->params['id']);
        $data['titulo'] = $arrayTitulo['dados'];
        $this->render($this->action, "createByTitulo", $data);
    }

    public function _createByMatricula() {
        $matricula = new Matricula();
        $titulo = new Titulo();
        $array = $matricula->get($this->params['id']);
        $data['matricula'] = $array['dados'];
        $data['titulos'] = $titulo->listarByMatricula($data['matricula']['id']);
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
                    <a href="<?= application ?>acrescimo/createByMatricula/<?php echo $matricula['dados']['id']; ?>">
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
        $acrescimo = new Acrescimo();
        $data = $acrescimo->get($this->params['id']);
        $this->class = array("enum" => new Enum(), "number" => new Number());
        $this->render($this->action, "show", $data);
    }

    public function _showByTitulo() {
        $acrescimo = new Acrescimo();
        $data = $acrescimo->get($this->params['id']);
        $this->class = array("enum" => new Enum(), "number" => new Number());
        $this->render($this->action, "showByTitulo", $data);
    }

    public function _editByTitulo() {
        $acrescimo = new Acrescimo();
        $data = $acrescimo->get($this->params['id']);
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum(), "number" => new Number());
        $this->render($this->action, "editByTitulo", $data);
    }

    public function _edit() {
        $acrescimo = new Acrescimo();
        $data = $acrescimo->get($this->params['id']);
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
        $this->class = array('funcoesHTML' => new FuncoesHTML(), "enum" => new Enum(), "numbers" => new Numbers());
        $this->render($this->action, "report", $data);
    }

    public function _SAVEBYTITULO() {
        $acrescimo = new Acrescimo();
        $number = new Number();
        $this->params['valor'] = $number->formatCurrency($this->params['valor']);
        $titulo = new Titulo();
        $array = $titulo->get($this->params['titulo']);
        $paramsTitulo = $array['dados'];
        if ($this->params['status'] == '1') {
            $paramsTitulo['valor'] = $paramsTitulo['valor'] + $this->params['valor'];
        }
        $paramsTitulo['configuracao'] = $paramsTitulo['configuracao_id'];
        if (!$titulo->update($paramsTitulo)) {
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Título!";
            $this->redirect($this->action, "listByTitulo", array("id" => $paramsTitulo['id']));
        } else {
            $this->params['idTitulo'] = $this->params['titulo'];
            if ($acrescimo->save($this->params)) {
                $_SESSION['flash'] = "Acréscimo salvo com Sucesso!";
                $this->redirect($this->action, "listByTitulo", array("id" => $paramsTitulo['id']));
            } else {
                $_SESSION['error'] = "Ocorreu um erro ao salvar o Acréscimo!";
                $this->redirect($this->action, "listByTitulo", array("id" => $paramsTitulo['id']));
                return;
            }
        }
    }

    public function _SAVE() {
        $acrescimo = new Acrescimo();
        $titulo = new Titulo();
        $number = new Number();
        $this->params['valor'] = $number->formatCurrency($this->params['valor']);
        foreach ($this->params['titulos'] as $idTitulo) {
            $array = $titulo->get($idTitulo);
            $paramsTitulo = $array['dados'];
            if ($this->params['status'] == '1') {
                $paramsTitulo['valor'] = $paramsTitulo['valor'] + $this->params['valor'];
            }
            $paramsTitulo['configuracao'] = $paramsTitulo['configuracao_id'];
            if (!$titulo->update($paramsTitulo)) {
                $_SESSION['error'] = "Ocorreu um erro ao alterar o Título!";
                $this->redirect($this->action, "create", null);
                return;
            } else {
                $this->params['idTitulo'] = $idTitulo;
                if ($acrescimo->save($this->params)) {
                    $_SESSION['flash'] = "Acréscimo salvo com Sucesso!";
                    $this->redirect($this->action, "list", null);
                } else {
                    $_SESSION['error'] = "Ocorreu um erro ao salvar o Acréscimo!";
                    $this->redirect($this->action, "list", null);
                    return;
                }
            }
        }
    }

    public function _UPDATEBYTITULO() {
        $acrescimo = new Acrescimo();
        $array = $acrescimo->get($this->params['id']);
        $arrayAcrescimo = $array['dados'];
        $number = new Number();
        $this->params['valor'] = $number->formatCurrency($this->params['valor']);
        $titulo = new Titulo();
        $array = $titulo->get($arrayAcrescimo['titulo_id']);
        $paramsTitulo = $array['dados'];
        if ($arrayAcrescimo['status'] == '1') {
            if ($this->params['status'] == '1') {
                $paramsTitulo['valor'] = $paramsTitulo['valor'] + ($this->params['valor'] - $arrayAcrescimo['valor']);
            } else {
                $paramsTitulo['valor'] = $paramsTitulo['valor'] - $arrayAcrescimo['valor'];
            }
        } else {
            if ($this->params['status'] == '1') {
                $paramsTitulo['valor'] = $paramsTitulo['valor'] + $this->params['valor'];
            }
        }
        $paramsTitulo['configuracao'] = $paramsTitulo['configuracao_id'];
        if (!$titulo->update($paramsTitulo)) {
            $_SESSION['error'] = "Ocorreu um erro ao editar o Acréscimo!";
            $this->redirect($this->action, "listByTitulo", array("id" => $paramsTitulo['id']));
        } else {
            if ($acrescimo->update($this->params)) {
                $_SESSION['flash'] = "Acréscimo editado com Sucesso!";
                $this->redirect($this->action, "listByTitulo", array("id" => $paramsTitulo['id']));
            } else {
                $_SESSION['error'] = "Ocorreu um erro ao editar o Acréscimo!";
                $this->redirect($this->action, "listByTitulo", array("id" => $paramsTitulo['id']));
                return;
            }
        }
    }

    public function _UPDATE() {
        $acrescimo = new Acrescimo();
        $array = $acrescimo->get($this->params['id']);
        $arrayAcrescimo = $array['dados'];
        $number = new Number();
        $this->params['valor'] = $number->formatCurrency($this->params['valor']);
        $titulo = new Titulo();
        $array = $titulo->get($arrayAcrescimo['titulo_id']);
        $paramsTitulo = $array['dados'];
        if ($arrayAcrescimo['status'] == '1') {
            if ($this->params['status'] == '1') {
                $paramsTitulo['valor'] = $paramsTitulo['valor'] + ($this->params['valor'] - $arrayAcrescimo['valor']);
            } else {
                $paramsTitulo['valor'] = $paramsTitulo['valor'] - $arrayAcrescimo['valor'];
            }
        } else {
            if ($this->params['status'] == '1') {
                $paramsTitulo['valor'] = $paramsTitulo['valor'] + $this->params['valor'];
            }
        }
        $paramsTitulo['configuracao'] = $paramsTitulo['configuracao_id'];
        if (!$titulo->update($paramsTitulo)) {
            $_SESSION['error'] = "Ocorreu um erro ao editar o Acréscimo!";
            $this->redirect($this->action, "list", null);
        } else {
            if ($acrescimo->update($this->params)) {
                $_SESSION['flash'] = "Acréscimo editado com Sucesso!";
                $this->redirect($this->action, "list", null);
            } else {
                $_SESSION['error'] = "Ocorreu um erro ao editar o Acréscimo!";
                $this->redirect($this->action, "list", null);
                return;
            }
        }
    }

    public function _DELETEBYTITULO() {
        $acrescimo = new Acrescimo();
        $array = $acrescimo->get($this->params['id']);
        $arrayAcrescimo = $array['dados'];
        $titulo = new Titulo();
        $array = $titulo->get($arrayAcrescimo['titulo_id']);
        $paramsTitulo = $array['dados'];
        if ($arrayAcrescimo['status'] == '1') {
            $paramsTitulo['valor'] = $paramsTitulo['valor'] - $arrayAcrescimo['valor'];
        }
        $paramsTitulo['configuracao'] = $paramsTitulo['configuracao_id'];
        if (!$titulo->update($paramsTitulo)) {
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Título!";
            $this->redirect($this->action, "listByTitulo", array("id" => $arrayAcrescimo['titulo_id']));
        } else {
            if ($acrescimo->delete($this->params)) {
                $_SESSION['flash'] = "Acréscimo deletado com Sucesso!";
                $this->redirect($this->action, "listByTitulo", array("id" => $arrayAcrescimo['titulo_id']));
            } else {
                $_SESSION['error'] = "Ocorreu um erro ao deletar o Acréscimo!";
                $this->redirect($this->action, "listByTitulo", array("id" => $arrayAcrescimo['titulo_id']));
            }
        }
    }

    public function _DELETE() {
        $acrescimo = new Acrescimo();
        $array = $acrescimo->get($this->params['id']);
        $arrayAcrescimo = $array['dados'];
        $titulo = new Titulo();
        $array = $titulo->get($arrayAcrescimo['titulo_id']);
        $paramsTitulo = $array['dados'];
        if ($arrayAcrescimo['status'] == '1') {
            $paramsTitulo['valor'] = $paramsTitulo['valor'] - $arrayAcrescimo['valor'];
        }
        $paramsTitulo['configuracao'] = $paramsTitulo['configuracao_id'];
        if (!$titulo->update($paramsTitulo)) {
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Título!";
            $this->redirect($this->action, "list", null);
        } else {
            if ($acrescimo->delete($this->params)) {
                $_SESSION['flash'] = "Acréscimo deletado com Sucesso!";
                $this->redirect($this->action, "list", null);
            } else {
                $_SESSION['error'] = "Ocorreu um erro ao deletar o Acréscimo!";
                $this->redirect($this->action, "list", null);
            }
        }
    }

    public function _result() {
        $conection = new Conection();
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
        $nossoNumero = $this->params['nossoNumero'];
        $matricula = $this->params['matricula'];
        $nome = $this->params['nome'];
        $valor = "";
        if ($this->params['valor'] != "") {
            $valor = "a.valor = '" . $this->params['valor'] . "' AND";
        }
        $parcela = $this->params['parcela'];
        $status = $this->params['status'];
        $query = "(SELECT a.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, pa.numero AS parcela FROM acrescimo a
                    INNER JOIN titulo t ON t.id = a.titulo_id
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno al ON al.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                    INNER JOIN grade g ON g.id = al.grade_id
                    WHERE p.nome LIKE '$nome%' AND
                          al.matricula LIKE '$matricula%' AND 
                          t.nosso_numero LIKE '$nossoNumero%' AND
                          pa.numero LIKE '$parcela' AND 
                          m.turma_id LIKE '$idTurma' AND
                          g.id LIKE '$idGrade' AND
                          " . $valor . " 
                          a.status LIKE '$status')
                  UNION
                  (SELECT a.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, '-' AS parcela FROM acrescimo a
                    INNER JOIN titulo t ON t.id = a.titulo_id
                    INNER JOIN aluno al ON al.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                    WHERE p.nome LIKE '$nome%' AND
                          al.matricula LIKE '$matricula%' AND 
                          t.nosso_numero LIKE '$nossoNumero%' AND
                          " . $valor . " 
                          a.status LIKE '$status')";
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
        $nossoNumero = $this->params['nossoNumero'];
        $matricula = $this->params['matricula'];
        $nome = $this->params['nome'];
        $valor = "";
        if ($this->params['valor'] != "") {
            $valor = "a.valor = '" . $this->params['valor'] . "' AND";
        }
        $parcela = $this->params['parcela'];
        if ($parcela != "%") {
            $data['parcela'] = $parcela;
        } else {
            $data['parcela'] = "Todas";
        }
        $status = $this->params['status'];
        $query = "(SELECT a.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, pa.numero AS parcela FROM acrescimo a
                    INNER JOIN titulo t ON t.id = a.titulo_id
                    INNER JOIN parcela pa ON pa.id = t.parcela_id
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno al ON al.id = m.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                    INNER JOIN grade g ON g.id = al.grade_id
                    WHERE p.nome LIKE '$nome%' AND
                          al.matricula LIKE '$matricula%' AND 
                          t.nosso_numero LIKE '$nossoNumero%' AND
                          pa.numero LIKE '$parcela' AND 
                          m.turma_id LIKE '$idTurma' AND
                          g.id LIKE '$idGrade' AND
                          " . $valor . " 
                          a.status LIKE '$status')
                  UNION
                  (SELECT a.*, t.id AS titulo, t.nosso_numero, p.nome, p.cpf, al.matricula, '-' AS parcela FROM acrescimo a
                    INNER JOIN titulo t ON t.id = a.titulo_id
                    INNER JOIN aluno al ON al.id = t.aluno_id
                    INNER JOIN pessoa p ON p.id = al.pessoa_id
                    WHERE p.nome LIKE '$nome%' AND
                          al.matricula LIKE '$matricula%' AND 
                          t.nosso_numero LIKE '$nossoNumero%' AND
                          " . $valor . " 
                          a.status LIKE '$status')";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['titulo'] = "Relatório de Acréscimos";
        $data['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "number" => new Number());
        $this->renderReport($this->action, "result", $data);
    }

}
?>
