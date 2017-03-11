<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../config/security.php';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>report/main.css" />
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title>Relatório do <?= name ?></title>
    </head>
    <body>
        <?
        foreach ($data['result'] as $value) {
            ?>
            <table style="page-break-after: always;">
                <tr>
                    <td>
                        <div class="corpo">
                            <?
                            include '../report/layout/header.php';
                            echo $value['value'];
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
            <?
        }
        ?>
    </body>
</html>
