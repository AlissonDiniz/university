<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WebcamService
 *
 * @author Alisson
 */
//include_once '../../config/security.php';
include_once '../config/urlmapping.php';
include_once '../config/Conection.php';

class WebcamService extends MainService {

    public $params;

    public function _index() {
        die();
    }
    public function _image() {
        $data = $this->params['id'];
        $this->render($this->action, "index", $data);
    }

    public function _upLoad() {
        $filename = "foto_" . $this->params['filename'] . ".png";
        $uri = '../images/profile/';
        $this->saveImage($this->params['image'], $uri . $filename);
    }

    public function saveImage($image, $filename) {
        if (file_exists($filename)) {
            unlink($filename);
            $this->gravaImage($image, $filename);
        } else {
            $this->gravaImage($image, $filename);
        }
    }

    public function gravaImage($imagem, $filename) {
        $imagemTemp = imagecreatefrompng($imagem);
        if (imagepng($imagemTemp, $filename)) {
            echo "Imagem salva com sucesso!";
        } else {
            echo "Nao foi possivel salvar a Imagem!";
        }
    }

}

?>