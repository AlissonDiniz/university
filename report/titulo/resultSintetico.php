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
                        <td width="100" style="text-align: center">
                            Nosso Número
                        </td>
                        <td width="80" style="text-align: center">
                            Matricula
                        </td>
                        <td width="380">
                            Nome
                        </td>
                        <td width="100" style="text-align: center">
                            Valor
                        </td>
                        <td width="80" style="text-align: center">
                            Vencimento
                        </td>
                        <td width="80" style="text-align: center">
                            Situação
                        </td>
                        <td width="60" style="text-align: center">
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
                    $valorTotal = 0;
                    foreach ($data['result'] as $value) {
                        $linhas++;
                        ?>
                        <tr>
                            <td style="text-align: center">
                                <? echo $value['dados']['nosso_numero']; ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $value['dados']['matricula']; ?>
                            </td>
                            <td>
                                <? echo $value['dados']['nome'] . "<br />" . $value['dados']['cpf']; ?>
                            </td>
                            <td style="text-align: left">
                                <?
                                $valorTotal = $valorTotal + $value['dados']['valor'];
                                echo $classFunction['number']->formatMoney($value['dados']['valor']);
                                ?>
                            </td>
                            <td style="text-align: center">
    <? echo $classFunction['data']->dataUSAToDataBrasil($value['dados']['vencimento']); ?>
                            </td>
                            <td style="text-align: center">
    <? echo $classFunction['enum']->enumOpcoes($value['dados']['situacao'], $classFunction['situacaoTitulo']->loadOpcoes()); ?>
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
                <span>Valor dos Títulos&nbsp;<? echo $classFunction['number']->formatMoney($valorTotal); ?></span>
            </div>
            <br />
            <?
            include_once '../report/layout/footer.php';
            ?>
        </div>
    </body>
</html>
