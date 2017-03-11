<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountService
 *
 * @author Alisson
 */
include_once '../class/User.php';
include_once '../config/Conection.php';

class AccountService extends MainService {

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
        $query = "SELECT * FROM usuario WHERE password = '$password'";
        $result = $conection->selectQuery($query);
        if ($conection->rows($result) > 0) {
            $username = str_replace("'", "", $this->params['username']);
            $query = "SELECT u.*, r.autoridade, r.modulo FROM usuario u 
                        INNER JOIN role r ON r.id = u.role_id
                        WHERE u.username = '$username' AND u.password = '$password'";
            $result = $conection->selectQuery($query);
            if ($conection->rows($result) > 0) {
                $array = $conection->fetch($result);
                if ($array['enabled'] == true) {
                    $_SESSION['system'] = "SYSMA";
                    $_SESSION['logged'] = true;
                    $_SESSION['id'] = $array['id'];
                    $_SESSION['username'] = $array['username'];
                    $_SESSION['nome'] = $array['nome'];
                    $_SESSION['autoridade'] = $array['autoridade'];
                    $_SESSION['modulo'] = $array['modulo'];
                    $this->redirect(application . "main");
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

    public function _logout() {
        unset($_SESSION);
        session_destroy();
        $this->redirect(service . "account/auth");
    }

}

?>
