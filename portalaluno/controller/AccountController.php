<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountController
 *
 * @author Alisson
 */
include_once 'MainController.php';
include_once '../../config/Conection.php';
include_once '../class/Aluno.php';
include_once '../../function/util/Data.php';

class AccountController extends MainController {

    public $params;

    public function _index() {
        $this->render($this->action, "auth", null);
    }

    public function _auth() {
        $this->render($this->action, "auth", null);
    }

    public function _logon() {
        $conection = new Conection();
        $password = sha1(str_replace("'", "", $this->params['password']));
        $query = "SELECT * FROM aluno WHERE password = '$password'";
        $result = $conection->selectQuery($query);
        if ($conection->rows($result) > 0) {
            $username = str_replace("'", "", $this->params['username']);
            $query = "SELECT a.*, pe.nome FROM aluno a 
                        INNER JOIN pessoa pe ON pe.id = a.pessoa_id
                        WHERE a.username = '$username' AND a.password = '$password'";
            $result = $conection->selectQuery($query);
            if ($conection->rows($result) > 0) {
                $array = $conection->fetch($result);
                if ($array['status'] == 1) {
                    @session_start();
                    $_SESSION['system'] = "SYSMAPORTALALUNO";
                    $_SESSION['logged'] = true;
                    $_SESSION['id'] = $array['id'];
                    $_SESSION['username'] = $array['username'];
                    $_SESSION['nome'] = $array['nome'];
                    $this->redirect("main", "home", null);
                } else {
                    $this->render($this->action, "auth", "Usuário desativado!");
                }
            } else {
                $this->render($this->action, "auth", "Login ou senha Inválidos!");
            }
        } else {
            $this->render($this->action, "auth", "Login ou senha Inválidos!");
        }
    }

    public function _mudarSenha() {
        $this->render($this->action, "mudarSenha", array("id" => $_SESSION['id']));
    }

    public function _ALTERARSENHA() {
        $aluno = new Aluno();
        $data = $aluno->get($this->params['id']);
        $this->params['password'] = sha1($this->params['password']);
        if ($data['dados']['password'] == sha1($this->params['passwordOld'])) {
            if ($aluno->updatePassword($this->params)) {
                $_SESSION['flash'] = "Senha alterada com Sucesso!";
                $this->redirect($this->action, "mudarSenha", array("id" => $aluno->id));
            } else {
                $_SESSION['error'] = "Ocorreu um erro ao alterar a Senha!";
                $this->redirect($this->action, "mudarSenha", null);
            }
        } else {
            $_SESSION['error'] = "Senha Anterior Inválida!";
            $this->redirect($this->action, "mudarSenha", null);
        }
    }

    public function _resetPassword() {
        $this->render($this->action, "resetPassword", null);
    }

    public function _validate() {
        $conection = new Conection();
        $data = new Data();
        $query = "SELECT a.id FROM pessoa p 
                    INNER JOIN aluno a ON a.pessoa_id = p.id 
                    WHERE p.cpf = '" . $this->params['cpf'] . "' AND 
                        p.data_nascimento = '" . $data->dataBrasilToDataUSA($this->params['dt']) . "' AND 
                        a.matricula = '" . $this->params['ra'] . "'";
        $result = $conection->selectQuery($query);
        if ($conection->rows($result) > 0) {
            $array = $conection->fetch($result);
            echo json_encode(array("status" => true, "id" => $array['id']));
        } else {
            echo json_encode(array("status" => false, "id" => 0));
        }
    }

    public function _RESETSENHA() {
        $aluno = new Aluno();
        $this->params['password'] = sha1($this->params['password']);
        if (!$aluno->updatePassword($this->params)) {
            $_SESSION['flash'] = "Ocorreu um erro ao alterar a senha!";
            $this->render($this->action, "resetPassword", null);
        } else {
            $_SESSION['flash'] = "Senha alterada com Sucesso!";
            header("Location: " . path);
        }
    }

    public function _logout() {
        unset($_SESSION);
        session_destroy();
        $this->redirect($this->action, "auth", null);
    }

}

?>
