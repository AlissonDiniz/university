<?php

$resultData = $data;
include "include/funcoes_santander_banespa.php";
?>
<html>
    <head>
        <?php
        include_once "include/css.php";
        ?>
    </head>
    <body>
    <?php
        foreach($resultData as $data){
    ?>
        <div style="page-break-after: always">
            <?php
            include "include/data_boleto.php";
            include "include/layout_lote.php";
            ?>
        </div>
    <?php
        }
    ?>
    </body>
</html>