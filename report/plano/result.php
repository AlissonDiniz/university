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
            <div style="float: left; width: 100%; text-align: left; font-size: 0.9em; margin: -10px 0 20px 0">
                <div style="float: left; margin: 5px; width: 900px">
                    <strong>Curso: </strong> <? echo $data['curso']['dados']['codigo'] . " - " . $data['curso']['dados']['nome']; ?>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <div style="float: left; width: 200px;">
                        <strong>Período: </strong> <? echo $data['periodo']['dados']['codigo']; ?>
                    </div>
                </div>
            </div>
            <table align="center" class="tabela" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <td width="300" style="text-align: center">
                            Curso
                        </td>
                        <td width="100">
                            Período
                        </td>
                        <td width="200" style="text-align: center">
                            Descrição
                        </td>
                        <td width="80" style="text-align: center">
                            Parcelas
                        </td>
                        <td width="100" style="text-align: center">
                            Valor
                        </td>
                        <td width="80" style="text-align: center">
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
                            <td width="300">
                                <? echo $value['dados']['curso']; ?>
                            </td>
                            <td>
                                <? echo $value['dados']['periodo']; ?>
                            </td>
                            <td>
                                <? echo $value['dados']['descricao']; ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $value['dados']['quantidade_parcelas']; ?>
                            </td>
                            <td style="text-align: right">
                                <? echo $classFunction['number']->formatMoney($value['dados']['valor']); ?>
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
