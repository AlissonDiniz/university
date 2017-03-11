<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Periodo
 *
 * @author Alisson
 */
require_once '../../config/Conection.php';

class Periodo {

    public $id;

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT * FROM periodo WHERE id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

}

?>
