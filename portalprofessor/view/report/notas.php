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
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title>Relatório do <?= name ?></title>
    </head>
    <body>
        <div class="corpo">
            <?
            include_once '../../report/layout/header.php';
            ?>
            <table align="center" class="tabela formee" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <td width="80">
                            R.A.
                        </td>
                        <td width="360">
                            Nome
                        </td>
                        <td width="100">
                            CPF
                        </td>
                        <td width="120" style="text-align: center">
                            Etapa
                        </td>
                        <td width="120" style="text-align: center">
                            Nota
                        </td>
                        <td width="100" style="border-right: none; text-align: center">
                            Última Data
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
                            <td>
                                <? echo $value['dados']['matricula']; ?>
                            </td>
                            <td>
                                <? echo $value['dados']['nome']; ?>
                            </td>
                            <td>
                                <? echo $value['dados']['cpf']; ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction['enum']->enumTipoEtapa($value['dados']['numero_etapa']); ?>
                            </td>
                            <td>
                                <div class="grid-12-12">
                                    <input style="text-align: center" disabled="disabled" name="nota" type="text" value="<? echo $classFunction['number']->formatNota($value['dados']['valor']); ?>" />
                                </div>
                            </td>
                            <td style="border-right: none; text-align: center">
                                <? echo $classFunction['data']->dataUSAToDataBrasil($value['dados']['data']); ?>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </tbody>
            </table>
            <div class="legendaFooter">
                <span>N&ordm; de Notas :&nbsp;<? echo $linhas; ?></span>
            </div>
            <br />
            <?
            include_once '../../report/layout/footer.php';
            ?>
        </div>
    </body>
</html>
