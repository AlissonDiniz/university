<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MatriculaController
 *
 * @author Alisson
 */
include_once '../class/Matricula.php';
include_once '../class/MatriculaTurmaDisciplina.php';
include_once '../class/Pessoa.php';
include_once '../class/Parametro.php';
include_once '../class/Pendencia.php';
include_once '../class/Periodo.php';
include_once '../class/Parcela.php';
include_once '../class/Plano.php';
include_once '../class/Turma.php';
include_once '../class/Titulo.php';
include_once '../class/Aluno.php';
include_once '../class/Grade.php';
include_once '../class/Curso.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/util/Number.php';
include_once '../function/util/Data.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/util/Data.php';
include_once '../function/enum/Turno.php';
include_once '../function/enum/SituacaoPeriodo.php';
include_once '../function/enum/FormaDeIngresso.php';
include_once '../function/enum/Estado.php';
include_once '../function/enum/EstadoCivil.php';
include_once '../function/enum/Deficiencia.php';
include_once '../function/enum/SituacaoAluno.php';
include_once '../function/enum/ModuloEnum.php';
include_once '../function/enum/TurmaEnum.php';
include_once '../function/enum/Turno.php';

class MatriculaController extends MainController {

    public $action;
    public $method;
    public $params;

    public function MatriculaController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_listAluno", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_createPessoa", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_createAluno", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_createMatricula", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_getTurma", "authority" => 4);
	$this->authorityMethod[] = array("name" => "_getPlano", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_alunos", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVEPESSOA", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVEALUNO", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
	$this->authorityMethod[] = array("name" => "_TRANCAR", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_result", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_resultReportAlunos", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $matricula = new Matricula();
        $zebraPagination = $this->paginate($matricula->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum(), "situacaoPeriodo" => new SituacaoPeriodo());
        $data = $matricula->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _listAluno() {
        $matricula = new Matricula();
        $data['aluno'] = $this->params['aluno'];
        $data['matricula'] = $matricula->listarByAluno($this->params['aluno']);
        $this->class = array("enum" => new Enum(), "situacaoPeriodo" => new SituacaoPeriodo());
        $this->render($this->action, "listAluno", $data);
    }

    public function _create() {
        $parametro = new Parametro();
        $arrayParametros = $parametro->get();
        $array = array();
        foreach ($arrayParametros as $value) {
            $array[] = array("value" => $value['periodo_matricula_id'], "nome" => $value['periodoMatricula']);
        }
        $data['parametros'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum());
        $this->render($this->action, "create", $data);
    }

    public function _createPessoa() {
        $this->class = array('funcoesHTML' => new FuncoesHTML(), 'estados' => new Estado(), "estadoCivil" => new EstadoCivil(), "deficiencia" => new Deficiencia());
        $this->render($this->action, "createPessoa", null);
    }

    public function _createAluno() {
        $pessoa = new Pessoa();
        $arrayPessoa = $pessoa->getByMatricula($this->params['id']);
        $data['pessoa'] = $arrayPessoa['dados'];
        $grade = new Grade();
        $parametro = new Parametro();
        $arrayGrades = $grade->listarGradesAtivas();
        $array = array();
        foreach ($arrayGrades as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['grades'] = $array;
        $arrayParametros = $parametro->get();
        $array = array();
        foreach ($arrayParametros as $value) {
            $array[] = array("value" => $value['periodo_matricula_id'], "nome" => $value['periodoMatricula']);
        }
        $data['parametros'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "formaIngresso" => new FormaDeIngresso(), "turnos" => new Turno());
        $this->render($this->action, "createAluno", $data);
    }

    public function _createMatricula() {
        $aluno = new Aluno();
        $arrayAluno = $aluno->get($this->params['id']);
        $data['aluno'] = $arrayAluno['dados'];
        $parametro = new Parametro();
        $arrayParametros = $parametro->get();
        $array = array();
        foreach ($arrayParametros as $value) {
            $array[] = array("value" => $value['periodo_matricula_id'], "nome" => $value['periodoMatricula']);
        }
        $data['parametros'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum());
        $this->render($this->action, "createMatricula", $data);
    }

    public function _getTurma() {
        $turma = new Turma();
        foreach ($turma->getToAluno($this->params['aluno'], $this->params['p']) as $turma) {
            echo '<option value="' . $turma['id'] . '">' . $turma['codigo'] . '</option>';
        }
    }

    public function _getPlano() {
        $plano = new Plano();
        foreach ($plano->getToAluno($this->params['aluno'], $this->params['p']) as $plano) {
            echo '<option value="' . $plano['id'] . '">' . $plano['codigo'] . '</option>';
        }
    }

    public function _show() {
        $matricula = new Matricula();
        $data = $matricula->get($this->params['id']);
        $this->class = array("enum" => new Enum(), "situacaoPeriodo" => new SituacaoPeriodo());
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $matricula = new Matricula();
        $data = $matricula->get($this->params['id']);
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "situacaoPeriodo" => new SituacaoPeriodo());
        $this->render($this->action, "edit", $data);
    }

    public function _search() {
        $periodo = new Periodo();
        $arrayPeriodos = $periodo->listar();
        $array = array();
        foreach ($arrayPeriodos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "situacaoPeriodo" => new SituacaoPeriodo());
        $this->render($this->action, "search", $data);
    }

    public function _alunos() {
        $periodo = new Periodo();
        $grade = new Grade();
        $arrayGrades = $grade->listarGradesAtivas();
        $arrayPeriodos = $periodo->listar();
        $array = array();
        foreach ($arrayGrades as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo'] . " - " . $value['dados']['nome']);
        }
        $data['grades'] = $array;
        $array = array();
        foreach ($arrayPeriodos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['periodos'] = $array;
        $parametro = new Parametro();
        $arrayParametros = $parametro->get();
        $array = array();
        foreach ($arrayParametros as $value) {
            $periodoAtual = $value['periodo_atual_id'];
        }
        $data['periodoAtual'] = $periodoAtual;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "turma" => new TurmaEnum(), "situacaoPeriodo" => new SituacaoPeriodo());
        $this->render($this->action, "alunos", $data);
    }

    public function _SAVE() {
        $matricula = new Matricula();
        $titulo = new Titulo();
        if ($matricula->verificaMatriculaAluno($this->params['aluno'], $this->params['periodo'])) {
            $aluno = new Aluno();
            $arrayAluno = $aluno->get($this->params['aluno']);
            $pendencia = new Pendencia();
            if ($pendencia->getToPessoaBloqueia($arrayAluno['dados']['pessoa_id'])) {
                $_SESSION['error'] = "A Pessoa informada possui pendência que bloqueia a matricula!";
                $this->redirect($this->action, "create", null);
            } else {
                $this->params['responsavel'] = $arrayAluno['dados']['responsavel_id'];
                if ($matricula->save($this->params)) {
                    if ($this->createTitulos($this->params['plano'], $matricula->id)) {
                        $_SESSION['flash'] = "Aluno Matriculado com Sucesso!";
                        $this->redirect($this->action, "show", array("id" => $matricula->id));
                    } else {
                        $_SESSION['error'] = "Ocorreu um erro no título ao matricular o Aluno!";
                        $this->redirect($this->action, "create", null);
                    }
                } else {
                    $_SESSION['error'] = "Ocorreu um erro ao matricula o Aluno!";
                    $this->redirect($this->action, "create", null);
                }
            }
        } else {
            $_SESSION['error'] = "O Aluno já está matriculado no período!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _SAVEPESSOA() {
        $pessoa = new Pessoa();
        $data = new Data();
        $this->params['cpf'] = str_replace("@", "", $this->params['cpf']) . str_replace("@", "", $this->params['cnpj']);
        $this->params['dataNascimento'] = $data->dataBrasilToDataUSA($this->params['dataNascimento']);
        if ($this->params['dataIdentidade'] != "") {
            $this->params['dataIdentidade'] = $data->dataBrasilToDataUSA($this->params['dataIdentidade']);
        }
        if ($pessoa->save($this->params)) {
            $_SESSION['flash'] = "Pessoa salva com Sucesso!";
            $this->redirect($this->action, "createAluno", array("id" => $pessoa->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar a Pessoa!";
            $this->redirect($this->action, "createPessoa", null);
        }
    }

    public function _SAVEALUNO() {
        if ($this->verificaAluno($this->params['pessoa'], $this->params['periodoIngresso'], $this->params['grade'])) {
            $_SESSION['error'] = "Aluno já existente!";
            $this->redirect($this->action, "createAluno", array("id" => $this->params['pessoa']));
        } else {
            $aluno = new Aluno();
            $periodo = new Periodo();
            $grade = new Grade();
            $arrayPeriodo = $periodo->get($this->params['periodoIngresso']);
            $arrayGrade = $grade->get($this->params['grade']);
            $this->params['matricula'] = $aluno->createMatricula(substr(str_replace(".", "", $arrayPeriodo['dados']['codigo']), 2, 3) . substr($arrayGrade['dados']['codigo'], 0, 3));
            $this->params['modulo'] = "01";
            if ($aluno->save($this->params)) {
                $_SESSION['flash'] = "Aluno salvo com Sucesso!";
                $this->redirect($this->action, "createMatricula", array("id" => $aluno->id));
            } else {
                $_SESSION['error'] = "Ocorreu um erro ao salvar o Aluno!";
                $this->redirect($this->action, "createAluno", array("id" => $this->params['pessoa']));
            }
        }
    }

    private function verificaAluno($pessoa, $periodoIngresso, $grade) {
        $conection = new Conection();
        $query = "SELECT id FROM aluno 
                    WHERE pessoa_id = '$pessoa' AND
                          periodo_ingresso_id = '$periodoIngresso' AND 
                          grade_id = '$grade'";
        $result = $conection->selectQuery($query);
        if ($conection->rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function createTitulos($idPlano, $idMatricula) {
        $titulo = new Titulo();
        $parcela = new Parcela();
        $plano = new Plano();
        $arrayPlano = $plano->get($idPlano);
        $arrayParcelas = $parcela->listar($idPlano);
        $nossoNumero = $titulo->getMaxNossoNumero();
        if (substr($nossoNumero, 0, 6) < date("Ym")) {
            $nossoNumero = date("Ym") . "00000";
        }
        foreach ($arrayParcelas as $parcela) {
            $nossoNumero = $nossoNumero + 1;
            $params = array("parcela" => $parcela['dados']['id'],
                "matricula" => $idMatricula,
                "configuracao" => $arrayPlano['dados']['configuracao_id'],
                "nossoNumero" => $nossoNumero,
                "vencimento" => $parcela['dados']['data_vencimento'],
                "valor" => $parcela['dados']['valor'],
                "situacao" => "A",
                "status" => 1,
                "linhaDigitavel" => "",
                "observacao" => "",
                "userCreate" => $this->params['userCreate']
            );
            if (!$titulo->save($params)) {
                return false;
                die();
            }
        }
        return true;
    }

    public function _UPDATE() {
        $matricula = new Matricula();
        if ($matricula->update($this->params)) {
            $_SESSION['flash'] = "Matricula alterada com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $matricula->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar a Matricula!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _DELETE() {
        $matricula = new Matricula();
        if ($matricula->delete($this->params)) {
            $_SESSION['flash'] = "Matricula deletada com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar a Matricula!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _TRANCAR() {
        $matricula = new Matricula();
        $matriculaTurmaDisciplina = new MatriculaTurmaDisciplina();
        $trancarDisciplinas = true;
        if ($this->params['situacao'] == "MT") {
            $situacaoMatricula = "ME";
            $situacaoDisciplina = "EC";
            $statusTitulo = "1";
        } else {
            $situacaoMatricula = "MT";
            $situacaoDisciplina = "TR";
            $statusTitulo = "0";
        }
        foreach ($matriculaTurmaDisciplina->listar($this->params['id']) as $value) {
            $trancarDisciplinas = $matriculaTurmaDisciplina->updateSituacao(array("id" => $value["dados"]["id"], "situacao" => $situacaoDisciplina));
        }
        if ($trancarDisciplinas) {
            if ($matricula->updateSituacao(array("id" => $this->params['id'], "situacao" => $situacaoMatricula))) {
                $titulo = new Titulo();
                foreach ($titulo->findByMatricula($this->params['id']) as $value) {
                    if (strtotime($value['dados']['vencimento']) >= strtotime(date("Y-m-d")) && $value['dados']['situacao'] != "B") {
                        if (!$titulo->updateStatus(array("id" => $value['dados']['id'], "status" => $statusTitulo))) {
                            $_SESSION['error'] = "Ocorreu um erro ao alterar a Matricula!";
                            $this->redirect($this->action, "show", array("id" => $this->params['id']));
                            return;
                        }
                    }
                }
                if ($this->params['situacao'] == "MT") {
                    $_SESSION['flash'] = "Matricula Destrancada com Sucesso!";
                } else {
                    $_SESSION['flash'] = "Matricula Trancada com Sucesso!";
                }
                $this->redirect($this->action, "show", array("id" => $this->params['id']));
            } else {
                $_SESSION['error'] = "Ocorreu um erro ao alterar a Matricula!";
                $this->redirect($this->action, "show", array("id" => $this->params['id']));
            }
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar as Disciplinas da Matricula!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        }
    }

    public function _result() {
        $conection = new Conection();
        $matricula = $this->params['matricula'];
        $nome = $this->params['nome'];
        $nomeResponsavel = $this->params['nomeResponsavel'];
        $periodo = $this->params['periodo'];
        $situacao = $this->params['situacao'];
        $status = $this->params['status'];
        $query = "SELECT m.*, a.matricula, pe.nome, pe2.id AS idResponsavel, pe2.cpf AS cpfResponsavel, pe2.nome AS responsavel, p.codigo AS periodo, t.codigo AS turma, pl.descricao AS plano FROM matricula m
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN pessoa pe ON pe.id = a.pessoa_id
                    INNER JOIN pessoa pe2 ON pe2.id = m.responsavel_id
                    INNER JOIN periodo p ON p.id = m.periodo_id
                    INNER JOIN turma t ON m.turma_id = t.id
                    LEFT JOIN plano pl ON pl.id = m.plano_id 
                    WHERE a.matricula LIKE '$matricula%' AND
                          pe.nome LIKE '$nome%' AND 
                          pe2.nome LIKE '$nomeResponsavel%' AND 
                          m.periodo_id LIKE '$periodo' AND 
                          m.situacao LIKE '$situacao' AND 
                          m.status LIKE '$status'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = array("enum" => new Enum(), "situacaoPeriodo" => new SituacaoPeriodo());
        $this->render($this->action, "result", $arrayRetorno);
    }

    public function _resultReportAlunos() {
        $conection = new Conection();
        $grade = new Grade();
        $data = array();
        $idGrade = $this->params['grade'];
        $data['grade'] = $grade->get($this->params['grade']);
        $turma = $this->params['turma'];
        if ($turma != "%") {
            $data['turma'] = $turma;
        } else {
            $data['turma'] = "Todas";
        }
        $matricula = $this->params['matricula'];
        $periodoIngresso = $this->params['periodoIngresso'];
        $idPeriodo = $this->params['periodo'];
        $periodo = new Periodo();
        $data['periodo'] = $periodo->get($this->params['periodo']);
        $situacao = $this->params['situacao'];
        $dataInstance = new Data();
        $dataInicial = $dataInstance->dataBrasilToDataUSA($this->params['dataInicial']);
        $data['dataInicial'] = $this->params['dataInicial'];
        $dataFinal = $dataInstance->dataBrasilToDataUSA($this->params['dataFinal']);
        $data['dataFinal'] = $this->params['dataFinal'];
        $query = "SELECT 
                    m.*,
                    a.matricula,
                    pe.nome,
                    c.nome AS nomeCurso,
                    t.codigo AS turma
                    FROM matricula m
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN grade g ON a.grade_id = g.id
                    INNER JOIN curso c ON c.id = g.curso_id
                    INNER JOIN pessoa pe ON pe.id = a.pessoa_id
                    INNER JOIN periodo p ON p.id = m.periodo_id
                    INNER JOIN turma t ON t.id = m.turma_id
                    WHERE a.matricula LIKE '$matricula%' AND
                          g.id LIKE '$idGrade' AND
                          t.codigo LIKE '_______" . $turma . "_' AND
                          a.periodo_ingresso_id LIKE '$periodoIngresso%' AND
                          m.periodo_id LIKE '$idPeriodo' AND 
                          m.situacao LIKE '$situacao' AND 
                          m.data BETWEEN '$dataInicial' AND '$dataFinal 23:59'
                    ORDER BY pe.nome";

        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $data['titulo'] = "Relatório - Alunos Matriculados";
        $data['result'] = $arrayRetorno;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "enum" => new Enum(), "data" => new Data(), "situacaoPeriodo" => new SituacaoPeriodo());
        $this->renderReport($this->action, "resultAlunos", $data);
    }

}

?>
