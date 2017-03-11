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
include_once '../class/Professor.php';

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
        $query = "SELECT * FROM professor WHERE password = '$password'";
        $result = $conection->selectQuery($query);
        if ($conection->rows($result) > 0) {
            $username = str_replace("'", "", $this->params['username']);
            $query = "SELECT p.*, pe.nome FROM professor p 
                        INNER JOIN pessoa pe ON pe.id = p.pessoa_id
                        WHERE p.username = '$username' AND p.password = '$password'";
            $result = $conection->selectQuery($query);
            if ($conection->rows($result) > 0) {
                $array = $conection->fetch($result);
                if ($array['status'] == 1) {
                    session_start();
                    $query = "UPDATE professor SET ultimo_acesso = NOW() WHERE id = '" . $array['id'] . "'";
                    $result = $conection->executeUpdate($query);
                    $_SESSION['ultimoAcesso'] = $array['ultimo_acesso'];
                    $_SESSION['system'] = "SYSMAPORTALPROFESSOR";
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
        $professor = new Professor();
        $data = $professor->get($this->params['id']);
        $this->params['password'] = sha1($this->params['password']);
        if ($data['dados']['password'] == sha1($this->params['passwordOld'])) {
            if ($professor->updateSenha($this->params)) {
                $_SESSION['flash'] = "Senha alterada com Sucesso!";
                $this->redirect($this->action, "mudarSenha", array("id" => $professor->id));
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
        $query = "SELECT pr.id FROM pessoa p 
                    INNER JOIN professor pr ON pr.pessoa_id = p.id 
                    WHERE p.cpf = '" . $this->params['cpf'] . "' AND 
                        p.data_nascimento = '" . $data->dataBrasilToDataUSA($this->params['dt']) . "' AND 
                        pr.username = '" . $this->params['user'] . "'";
        $result = $conection->selectQuery($query);
        if ($conection->rows($result) > 0) {
            $array = $conection->fetch($result);
            echo json_encode(array("status" => true, "id" => $array['id']));
        } else {
            echo json_encode(array("status" => false, "id" => 0));
        }
    }

    public function _RESETSENHA() {
        $professor = new Professor();
        $this->params['password'] = sha1($this->params['password']);
        if (!$professor->updateSenha($this->params)) {
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
        $this->render($this->action, "auth", null);
    }

}

?>
