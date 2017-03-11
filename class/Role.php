<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Role
 *
 * @author Alisson
 */
class Role {

    public $id;

    public function listar() {
        $conection = new Conection();
        $query = "SELECT * FROM role ORDER BY autoridade";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

}

?>
