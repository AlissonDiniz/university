<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DisciplinaController
 *
 * @author Alisson
 */

include_once '../class/User.php';
include_once '../class/Role.php';
include_once '../config/security.php';
include_once '../config/Conection.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';

class UserController extends MainController {

    public $action;
    public $method;
    public $params;

    public function UserController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_list", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_create", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_show", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_edit", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_alterSenha", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_mudarSenha", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_search", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_SAVE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_UPDATESENHA", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_ALTERARSENHA", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_DELETE", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_result", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $user = new User();
        $this->class = new Enum();
        $data = $user->listar();
        $this->render($this->action, "list", $data);
    }

    public function _create() {
        $role = new Role();
        $arrayRole = $role->listar();
        $array = array();
        foreach ($arrayRole as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['regras'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML());
        $this->render($this->action, "create", $data);
    }

    public function _show() {
        $user = new User();
        $data = $user->get($this->params['id']);
        $this->class = new Enum();
        $this->render($this->action, "show", $data);
    }

    public function _edit() {
        $user = new User();
        $role = new Role();
        $arrayRole = $role->listar();
        $array = array();
        foreach ($arrayRole as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['descricao']);
        }
        $data['regras'] = $array;
        $data['user'] = $user->get($this->params['id']);
        $this->class = array("funcoesHTML" => new FuncoesHTML());
        $this->render($this->action, "edit", $data);
    }

    public function _alterSenha() {
        $this->render($this->action, "alterSenha", array("id" => $this->params['id']));
    }

    public function _mudarSenha() {
        $this->render($this->action, "mudarSenha", array("id" => $_SESSION['id']));
    }

    public function _search() {
        $role = new Role();
        $data = $role->listar();
        $this->render($this->action, "search", $data);
    }

    public function _SAVE() {
        $user = new User();
        if ($user->save($this->params)) {
            $_SESSION['flash'] = "Usuário salvo com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $user->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao salvar a Usuário!";
            $this->redirect($this->action, "create", null);
        }
    }

    public function _UPDATE() {
        $user = new User();
        if ($user->update($this->params)) {
            $_SESSION['flash'] = "Usuário alterado com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $user->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Usuario!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _UPDATESENHA() {
        $user = new User();
        if ($user->updateSenha($this->params)) {
            $_SESSION['flash'] = "Senha Usuário alterada com Sucesso!";
            $this->redirect($this->action, "show", array("id" => $user->id));
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao alterar o Usuario!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _ALTERARSENHA() {
        $user = new User();
        $data = $user->get($this->params['id']);
        if ($data['dados']['password'] == sha1($this->params['passwordOld'])) {
            if ($user->updateSenha($this->params)) {
                $_SESSION['flash'] = "Senha Usuário alterada com Sucesso!";
                $this->redirect($this->action, "mudarSenha", array("id" => $user->id));
            } else {
                $_SESSION['error'] = "Ocorreu um erro ao alterar o Usuario!";
                $this->redirect($this->action, "mudarSenha", null);
            }
        } else {
            $_SESSION['error'] = "Senha Anterior Inválida!";
            $this->redirect($this->action, "mudarSenha", null);
        }
    }

    public function _DELETE() {
        $user = new User();
        if ($user->delete($this->params)) {
            $_SESSION['flash'] = "Usuário deletado com Sucesso!";
            $this->redirect($this->action, "list", null);
        } else {
            $_SESSION['error'] = "Ocorreu um erro ao deletar o Usuario!";
            $this->redirect($this->action, "list", null);
        }
    }

    public function _result() {
        $conection = new Conection();
        $username = $this->params['username'];
        $nome = $this->params['nome'];
        $role = $this->params['role'];
        $status = $this->params['status'];
        $query = "SELECT u.*, r.descricao FROM usuario u 
                    INNER JOIN role r ON r.id = u.role_id
                    WHERE u.username LIKE '$username%' AND
                          u.nome LIKE '$nome%' AND 
                          u.enabled LIKE '$status' AND
                          u.role_id LIKE '$role'";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $this->class = new Enum();
        $this->render($this->action, "result", $arrayRetorno);
    }

}

?>
