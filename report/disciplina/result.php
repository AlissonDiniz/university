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
        <div class="corpo">
            <?
            include_once '../report/layout/header.php';
            ?>
            <table align="center" class="tabela" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <td width="80" style="text-align: center">
                            Código
                        </td>
                        <td width="420">
                            Nome
                        </td>
                        <td width="100" style="text-align: center">
                            Status
                        </td>
                        <td width="240" style="border-right: none">
                            Observação
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $linhas = 0;
                    foreach ($data['result'] as $value) {
                        $linhas++;
                        ?>
                        <tr>
                            <td style="text-align: center">
                                <? echo $value['dados']['codigo']; ?>
                            </td>
                            <td>
                                <? echo $value['dados']['nome']; ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction['enum']->enumStatus($value['dados']['status']); ?>
                            </td>
                            <td style="border-right: none">
                                <? echo $value['dados']['observacao']; ?>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </tbody>
            </table>
            <div class="legendaFooter">
                <span>N&ordm; de Linhas :&nbsp;<? echo $linhas; ?></span>
            </div>
            <br />
            <?
            include_once '../report/layout/footer.php';
            ?>
        </div>
    </body>
</html>
