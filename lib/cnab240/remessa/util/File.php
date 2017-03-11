<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of File
 *
 * @author Alisson
 */
class File {

    public function download($uriFile) {
        if (file_exists($uriFile)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($uriFile));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($uriFile));
            ob_clean();
            flush();
            readfile($uriFile);
            exit;
        } else {
            echo "File not found!";
            exit;
        }
    }

}

?>
