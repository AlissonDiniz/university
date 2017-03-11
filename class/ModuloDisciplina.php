<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modulo
 *
 * @author Alisson
 */
require_once '../config/Conection.php';

class ModuloDisciplina {

    public $id;

    public function listar($modulo) {
        $conection = new Conection();
        $query = "SELECT md.*, d.codigo, d.nome, d.carga_horaria FROM modulo_disciplina md
                    INNER JOIN disciplina d ON md.disciplina_id = d.id
                    WHERE md.modulo_id = '$modulo' ORDER BY data LIMIT 50";
        $result = $conection->selectQuery($query);
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        return $arrayRetorno;
    }

    public function get($id) {
        $conection = new Conection();
        $query = "SELECT md.*, d.codigo, d.nome, d.carga_horaria FROM modulo_disciplina md
                    INNER JOIN disciplina d ON md.disciplina_id = d.id
                    WHERE md.id = '$id'";
        $result = $conection->selectQuery($query);
        return array("dados" => $conection->fetch($result));
    }

    public function save($params) {
        $conection = new Conection();
        $modulo = $params['modulo'];
        $disciplina = $params['disciplina'];
        $obrigatorio = $params['obrigatorio'];
        $userCreate = $params['userCreate'];
        $query = "INSERT INTO modulo_disciplina 
                    (modulo_id, disciplina_id, obrigatorio, data, user_create)
                  VALUES
                  ('$modulo', '$disciplina', '$obrigatorio', NOW(), '$userCreate')";
        if (!$conection->executeUpdate($query)) {
            return false;
        }

        $query = "SELECT id FROM modulo_disciplina WHERE modulo_id = '$modulo' AND disciplina_id = '$disciplina' ORDER BY data DESC LIMIT 1";
        $result = $conection->selectQuery($query);
        $array = $conection->fetch($result);
        $this->id = $array[0];
        return true;
    }

    public function update($params) {
        $conection = new Conection();
        $id = $params['id'];
        $obrigatorio = $params['obrigatorio'];
        $query = "UPDATE modulo_disciplina 
                    SET obrigatorio = '$obrigatorio'
                  WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {return false;}
        $this->id = $id;
        return true;
    }

    public function delete($params) {
        $conection = new Conection();
        $id = $params['id'];
        $query = "DELETE FROM modulo_disciplina WHERE id = '$id'";
        if (!$conection->executeUpdate($query)) {
            return false;
        }
        return true;
    }

}

?>
