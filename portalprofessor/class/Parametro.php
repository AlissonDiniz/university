<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Parametro
 *
 * @author Alisson
 */
require_once '../../config/Conection.php';

class Parametro {

    public $id;

    public function get() {
        $conection = new Conection();
        $query = "SELECT pa.*, p.codigo AS periodoAtual, p2.codigo AS periodoMatricula FROM parametros pa
                    INNER JOIN periodo p ON p.id = pa.periodo_atual_id
                    INNER JOIN periodo p2 ON p2.id = pa.periodo_matricula_id
                    LIMIT 1";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

}

?>
