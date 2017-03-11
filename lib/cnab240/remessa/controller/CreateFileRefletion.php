<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateFileRefletion
 *
 * @author Alisson
 */
include_once '../class/HeaderFile.php';
include_once '../class/HeaderLotFile.php';
include_once '../class/SegmentPFile.php';
include_once '../class/SegmentQFile.php';
include_once '../class/SegmentRFile.php';
include_once '../class/SegmentSFile.php';
include_once '../class/TrailerFile.php';
include_once '../class/TrailerLotFile.php';

class CreateFileRefletion {

    private $file;

    public function createFile($arrayObjects, $uriFile) {
        if (file_exists($uriFile)) {
            return false;
        } else {
            $this->file = fopen($uriFile, "x");


            foreach ($arrayObjects as $object) {
                $contentLine = "";

                foreach (get_class_vars(get_class($object)) as $var) {
                    $method = "get".ucfirst($var);
                    $contentLine = $contentLine.$object->$method;
                }

                fwrite($this->file, $contentLine);
            }
            fclose($this->file);
        }
    }

}
?>
