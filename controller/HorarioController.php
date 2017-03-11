<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HorarioController
 *
 * @author Alisson
 */
include_once '../class/Horario.php';
include_once '../class/TurmaDisciplina.php';
include_once '../class/Sala.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/util/Data.php';
include_once '../function/enum/AulaEnum.php';
include_once '../function/enum/Turno.php';
include_once '../function/enum/DiaSemana.php';

class HorarioController extends MainController {

    public $action;
    public $method;
    public $params;

    public function HorarioController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_listByTd", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_listByD", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_showByTd", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_editByTd", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATEBYTD", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETEBYTD", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_result", "authority" => 4);
        $this->authorityMethod[] = array("name" => "verificaChoque", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $horario = new Horario();
        $zebraPagination = $this->paginate($horario->count());
        $this->class = array('pagination' => $zebraPagination['pagination'], 'enum' => new Enum(), 'turno' => new Turno, "diaSemana" => new DiaSemana(), "aulas" => new AulaEnum());
        $data = $horario->listarLimit($zebraPagination['limit']);
        $this->render($this->action, "list", $data);
    }

    public function _listByTd() {
        $horario = new Horario();
        $turmaDisciplina = new TurmaDisciplina();
        $arrayTurmaDisciplina = $turmaDisciplina->get($this->params['td']);
        $data['turmaDisciplina'] = $arrayTurmaDisciplina['dados'];
        $data['horario'] = $horario->listar($this->params['td']);
        $this->class = array('enum' => new Enum(), 'turno' => new Turno, "diaSemana" => new DiaSemana(), "aulas" => new AulaEnum());
        $this->render($this->action, "listByTd", $data);
    }

    public function _listByTurma() {
        $horario = new Horario();
        $turmaDisciplina = new TurmaDisciplina();
        $arrayTurmaDisciplina = $turmaDisciplina->get($this->params['td']);
        $data['turmaDisciplina'] = $arrayTurmaDisciplina['dados'];
        $data['horario'] = $horario->listar($this->params['td']);
        $this->class = array('enum' => new Enum(), 'turno' => new Turno, "diaSemana" => new DiaSemana(), "aulas" => new AulaEnum());
        $this->render($this->action, "listByTurma", $data);
    }

    public function _listByD() {
        $horario = new Horario();
        $turmaDisciplina = new TurmaDisciplina();
        $arrayTurmaDisciplina = $turmaDisciplina->get($this->params['td']);
        $data['turmaDisciplina'] = $arrayTurmaDisciplina['dados'];
        $data['horario'] = $horario->listar($this->params['td']);
        $this->class = array('enum' => new Enum(), 'turno' => new Turno, "diaSemana" => new DiaSemana(), "aulas" => new AulaEnum());
        $this->render($this->action, "listByD", $data);
    }

    public function _create() {
        $sala = new Sala();
        $arraySala = array();
        foreach ($sala->listar() as $value) {
            $arraySala[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['salas'] = $arraySala;
        $turmaDisciplina = new TurmaDisciplina();
        $arrayTD = $turmaDisciplina->get($this->params['td']);
        $data['turmaDisciplina'] = $arrayTD['dados'];
        $turno = new Turno();
        $turnoFixo = array();
        foreach ($turno->loadOpcoes() as $value) {
            if ($value['value'] == substr($data['turmaDisciplina']['turma'], 9, 1)) {
                $turnoFixo[0] = array("value" => $value['value'], "nome" => $value['nome']);
            }
        }
        $data['by'] = $this->params['by'];
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "turno" => $turnoFixo, "diaSemana" => new DiaSemana(), "aulas" => new AulaEnum());
        $this->render($this->action, "create", $data);
    }

    public function _show() {
        $horario = new Horario();
        $data = $horario->get($this->params['id']);
        $data['horario'] = $data['dados'];
        $turmaDisciplina = new TurmaDisciplina();
        $arrayData = $turmaDisciplina->get($data['horario']['turma_disciplina_id']);
        $data['turmaDisciplina'] = $arrayData['dados'];
        $this->class = array('enum' => new Enum(), 'turno' => new Turno, "diaSemana" => new DiaSemana(), "aulas" => new AulaEnum());
        $this->render($this->action, "show", $data);
    }

    public function _showByTd() {
        $horario = new Horario();
        $data = $horario->get($this->params['id']);
        $data['horario'] = $data['dados'];
        $turmaDisciplina = new TurmaDisciplina();
        $arrayData = $turmaDisciplina->get($data['horario']['turma_disciplina_id']);
        $data['turmaDisciplina'] = $arrayData['dados'];
        $this->class = array('enum' => new Enum(), 'turno' => new Turno, "diaSemana" => new DiaSemana(), "aulas" => new AulaEnum());
        $this->render($this->action, "showByTd", $data);
    }

    public function _edit() {
        $horario = new Horario();
        $data = $horario->get($this->params['id']);
        $data['horario'] = $data['dados'];
        $sala = new Sala();
        $arraySala = array();
        foreach ($sala->listar() as $value) {
            $arraySala[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['salas'] = $arraySala;
        $turmaDisciplina = new TurmaDisciplina();
        $arrayData = $turmaDisciplina->get($data['horario']['turma_disciplina_id']);
        $data['turmaDisciplina'] = $arrayData['dados'];
        $this->class = array('funcoesHTML' => new FuncoesHTML(), 'enum' => new Enum(), 'turno' => new Turno, "diaSemana" => new DiaSemana(), "aulas" => new AulaEnum());
        $this->render($this->action, "edit", $data);
    }

    public function _editByTd() {
        $horario = new Horario();
        $data = $horario->get($this->params['id']);
        $data['horario'] = $data['dados'];
        $sala = new Sala();
        $arraySala = array();
        foreach ($sala->listar() as $value) {
            $arraySala[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['salas'] = $arraySala;
        $turmaDisciplina = new TurmaDisciplina();
        $arrayData = $turmaDisciplina->get($data['horario']['turma_disciplina_id']);
        $data['turmaDisciplina'] = $arrayData['dados'];
        $this->class = array('funcoesHTML' => new FuncoesHTML(), 'enum' => new Enum(), 'turno' => new Turno, "diaSemana" => new DiaSemana(), "aulas" => new AulaEnum());
        $this->render($this->action, "editByTd", $data);
    }

    public function _SAVE() {
        $horario = new Horario();
        $inicioParams = str_replace(":", "", $this->params['inicio']) + 0;
        $terminoParams = str_replace(":", "", $this->params['termino']) + 0;
        foreach ($horario->getToSala($this->params['sala'], $this->params['dia']) as $value) {
            $inicioValue = str_replace(":", "", $value['dados']['inicio']) + 0;
            $terminoValue = str_replace(":", "", $value['dados']['termino']) + 0;
            if ($this->verificaChoque($value['dados']['tipoHorario'], $inicioValue, $terminoValue, $inicioParams, $terminoParams)) {
                $_SESSION['error'] = "A Sala informada já está alocada no horário de " . $value['dados']['inicio'] . " às " . $value['dados']['termino'] . "!";
                $this->redirect($this->action, "create", array("id" => "?td=" . $this->params['td']));
                die();
            }
        }
        foreach ($horario->getToProfessor($this->params['professor'], $this->params['dia']) as $value) {
            $inicioValue = str_replace(":", "", $value['dados']['inicio']) + 0;
            $terminoValue = str_replace(":", "", $value['dados']['termino']) + 0;
            if ($this->verificaChoque($value['dados']['tipoHorario'], $inicioValue, $terminoValue, $inicioParams, $terminoParams)) {
                $_SESSION['error'] = "O Professor informado já está alocado no horário de " . $value['dados']['inicio'] . " às " . $value['dados']['termino'] . "!";
                $this->redirect($this->action, "create", array("id" => "?td=" . $this->params['td']));
                die();
            }
        }
        if ($horario->save($this->params)) {
            if ($this->params['by'] == "turma") {
                $_SESSION['flash'] = "Horário salvo com Sucesso!";
                $this->redirect($this->action, "listByTurma", array("id" => "?td=" . $this->params['td']));
            } else {
                $_SESSION['flash'] = "Horário salvo com Sucesso!";
                $this->redirect($this->action, "listByTd", array("id" => "?td=" . $this->params['td']));
            }
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar o Horário!";
            $this->redirect($this->action, "create", array("id" => "?by=" . $this->params['by'] . "td=" . $this->params['td']));
        }
    }

    public function _UPDATE() {
        $horario = new Horario();
        $inicioParams = str_replace(":", "", $this->params['inicio']) + 0;
        $terminoParams = str_replace(":", "", $this->params['termino']) + 0;
        foreach ($horario->getToSala($this->params['sala'], $this->params['dia']) as $value) {
            $inicioValue = str_replace(":", "", $value['dados']['inicio']) + 0;
            $terminoValue = str_replace(":", "", $value['dados']['termino']) + 0;
            if ($this->verificaChoque($value['dados']['tipoHorario'], $inicioValue, $terminoValue, $inicioParams, $terminoParams)) {
                $_SESSION['error'] = "A Sala informada já está alocada no horário de " . $value['dados']['inicio'] . " às " . $value['dados']['termino'] . "!";
                $this->redirect($this->action, "show", array("id" => $this->params['id']));
                die();
            }
        }
        foreach ($horario->getToProfessor($this->params['professor'], $this->params['dia']) as $value) {
            $inicioValue = str_replace(":", "", $value['dados']['inicio']) + 0;
            $terminoValue = str_replace(":", "", $value['dados']['termino']) + 0;
            if ($this->verificaChoque($value['dados']['tipoHorario'], $inicioValue, $terminoValue, $inicioParams, $terminoParams)) {
                $_SESSION['error'] = "O Professor informado já está alocado no horário de " . $value['dados']['inicio'] . " às " . $value['dados']['termino'] . "!";
                $this->redirect($this->action, "show", array("id" => $this->params['id']));
                die();
            }
        }
        if ($horario->update($this->params)) {
            $_SESSION['flash'] = "Horário alterado com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Horário!";
            $this->redirect($this->action, "show", array("id" => $this->params['id']));
        }
    }

    public function _UPDATEBYTD() {
        $horario = new Horario();
        $inicioParams = str_replace(":", "", $this->params['inicio']) + 0;
        $terminoParams = str_replace(":", "", $this->params['termino']) + 0;
        foreach ($horario->getToSala($this->params['sala'], $this->params['dia']) as $value) {
            $inicioValue = str_replace(":", "", $value['dados']['inicio']) + 0;
            $terminoValue = str_replace(":", "", $value['dados']['termino']) + 0;
            if ($this->verificaChoque($value['dados']['tipoHorario'], $inicioValue, $terminoValue, $inicioParams, $terminoParams)) {
                $_SESSION['error'] = "A Sala informada já está alocada no horário de " . $value['dados']['inicio'] . " às " . $value['dados']['termino'] . "!";
                $this->redirect($this->action, "showByTd", array("id" => $this->params['id']));
                die();
            }
        }
        foreach ($horario->getToProfessor($this->params['professor'], $this->params['dia']) as $value) {
            $inicioValue = str_replace(":", "", $value['dados']['inicio']) + 0;
            $terminoValue = str_replace(":", "", $value['dados']['termino']) + 0;
            if ($this->verificaChoque($value['dados']['tipoHorario'], $inicioValue, $terminoValue, $inicioParams, $terminoParams)) {
                $_SESSION['error'] = "O Professor informado já está alocado no horário de " . $value['dados']['inicio'] . " às " . $value['dados']['termino'] . "!";
                $this->redirect($this->action, "showByTd", array("id" => $this->params['id']));
                die();
            }
        }
        if ($horario->update($this->params)) {
            $_SESSION['flash'] = "Horário alterado com Sucesso!";
            $this->redirect($this->action, "showByTd", array("id" => $this->params['id']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Horário!";
            $this->redirect($this->action, "showByTd", array("id" => $this->params['id']));
        }
    }

    public function _DELETE() {
        $horario = new Horario();
        $data = $horario->get($this->params['id']);
        if ($horario->delete($this->params)) {
            $_SESSION['flash'] = "Horário deletado com Sucesso!";
            $this->redirect($this->action, "list", array("id" => "?td=" . $data['dados']['turma_disciplina_id']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar o Horário!";
            $this->redirect($this->action, "list", array("id" => "?td=" . $data['dados']['turma_disciplina_id']));
        }
    }

    public function _DELETEBYTD() {
        $horario = new Horario();
        $data = $horario->get($this->params['id']);
        if ($horario->delete($this->params)) {
            $_SESSION['flash'] = "Horário deletado com Sucesso!";
            $this->redirect($this->action, "listByTd", array("id" => "?td=" . $data['dados']['turma_disciplina_id']));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar o Horário!";
            $this->redirect($this->action, "listByTd", array("id" => "?td=" . $data['dados']['turma_disciplina_id']));
        }
    }

    public function _search() {
        $sala = new Sala();
        $arraySala = array();
        foreach ($sala->listar() as $value) {
            $arraySala[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['codigo']);
        }
        $data['salas'] = $arraySala;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "turno" => new Turno(), "diaSemana" => new DiaSemana(), "aulas" => new AulaEnum());
        $this->render($this->action, "search", $data);
    }

    public function _result() {
        $conection = new Conection();
        $codigoTurma = $this->params['codigoTurma'];
        $codigoDisciplina = $this->params['codigoDisciplina'];
        $nomeDisciplina = $this->params['nomeDisciplina'];
        $nomeProfessor = $this->params['nomeProfessor'];
        $this->params['inicio'] != '' ? $inicioQuery = "h.inicio = '" . $this->params['inicio'] . "' AND" : $inicioQuery = "";
        $this->params['termino'] != '' ? $terminoQuery = "h.termino = '" . $this->params['termino'] . "' AND" : $terminoQuery = "";
        $dia = $this->params['dia'];
        $sala = $this->params['sala'];
        $turno = $this->params['turno'];
        $query = "SELECT h.*, s.codigo AS sala, pe.nome AS professor FROM horario h
                    INNER JOIN sala s ON s.id = h.sala_id
                    INNER JOIN turma_disciplina td ON h.turma_disciplina_id = td.id
                    INNER JOIN turma t ON t.id = td.turma_id
                    INNER JOIN disciplina d ON d.id = td.disciplina_id
                    INNER JOIN professor p ON p.id = h.professor_id
                    INNER JOIN pessoa pe ON pe.id = p.pessoa_id
                    WHERE t.codigo LIKE '$codigoTurma%' AND
                          d.codigo LIKE '$codigoDisciplina%' AND
                          d.nome LIKE '$nomeDisciplina%' AND
                          pe.nome LIKE '$nomeProfessor%' AND
                          $inicioQuery
                          $terminoQuery
                          h.sala_id LIKE '$sala' AND
                          h.dia LIKE '$dia' AND
                          h.turno LIKE '$turno'
                    ORDER BY h.data DESC";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = array('enum' => new Enum(), 'turno' => new Turno, "diaSemana" => new DiaSemana(), "aulas" => new AulaEnum());
        $this->render($this->action, "result", $arrayRetorno);
    }

    public function verificaChoque($tipo, $inicioParams, $terminoParams, $inicioValue, $terminoValue) {
        if ($tipo == "0") {
            if ($inicioValue >= $terminoParams || $terminoValue <= $inicioParams) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

}


?>

