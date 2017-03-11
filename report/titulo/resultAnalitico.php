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
        <div class="corpo" style="width: 1100px">
            <?
            include_once '../report/layout/header.php';
            ?>
            <table align="center" class="tabela" cellpadding="5" cellspacing="0" style="width: 1100px">
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
                        <td width="100" style="text-align: center">
                            Valor Restante
                        </td>
                        <td width="100" style="text-align: center">
                            Valor Multa
                        </td>
                        <td width="100" style="text-align: center">
                            Valor Juros
                        </td>
                        <td width="100" style="text-align: center">
                            Valor Desconto
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
                    $valorTotalRestante = 0;
                    $valorTotalMulta = 0;
                    $valorTotalJuros = 0;
                    $valorTotalDesconto = 0;
                    foreach ($data['result'] as $value) {
                        $linhas++;
                        ?>
                        <tr>
                            <td style="text-align: center; font-size: 9px">
                                <? echo $value['dados']['nosso_numero']; ?>
                            </td>
                            <td style="text-align: center; font-size: 9px">
                                <? echo $value['dados']['matricula']; ?>
                            </td>
                            <td style="font-size: 8px">
                                <? echo $value['dados']['nome'] . "<br />" . $value['dados']['cpf']; ?>
                            </td>
                            <td style="text-align: left; font-size: 9px">
                                <? $valorTotal = $valorTotal + $value['dados']['valor']; 
                                echo $classFunction['number']->formatMoney($value['dados']['valor']); ?>
                            </td>
                            <td style="text-align: left; font-size: 9px">
                                <? $valorTotalRestante = $valorTotalRestante + $value['dados']['valor_restante'];
                                echo $classFunction['number']->formatMoney($value['dados']['valor_restante']); ?>
                            </td>
                            <td style="text-align: left; font-size: 9px">
                                <?
                                $valorTotalMulta = $valorTotalMulta + $value['dados']['valor_multa'];
                                echo $classFunction['number']->formatMoney($value['dados']['valor_multa']);
                                ?>
                            </td>
                            <td style="text-align: left; font-size: 9px">
                                <?
                                $valorTotalJuros = $valorTotalJuros + $value['dados']['valor_juros'];
                                echo $classFunction['number']->formatMoney($value['dados']['valor_juros']);
                                ?>
                            </td>
                            <td style="text-align: left; font-size: 9px">
                                <?
                                $valorTotalDesconto = $valorTotalDesconto + $value['dados']['valor_desconto'];
                                echo $classFunction['number']->formatMoney($value['dados']['valor_desconto']);
                                ?>
                            </td>
                            <td style="text-align: center; font-size: 9px">
                                <? echo $classFunction['data']->dataUSAToDataBrasil($value['dados']['vencimento']); ?>
                            </td>
                            <td style="text-align: center; font-size: 9px">
                                <? echo $classFunction['enum']->enumOpcoes($value['dados']['situacao'], $classFunction['situacaoTitulo']->loadOpcoes()); ?>
                            </td>
                            <td style="text-align: center; font-size: 9px">
                                <? echo $classFunction['enum']->enumStatus($value['dados']['status']); ?>
                            </td>
                            <td style="border-right: none; font-size: 9px">
                        <? echo $value['dados']['observacao']; ?>
                            </td>
                        </tr>
    <?
}
?>
                </tbody>
            </table>
            <div class="legendaFooter">
                <span style="font-size: 10px">N&ordm; de Linhas :&nbsp;<? echo $linhas; ?></span>
                <span style="font-size: 10px">Valor dos Títulos&nbsp;<? echo $classFunction['number']->formatMoney($valorTotal); ?></span>
                <span style="font-size: 10px">Valor Restante dos Títulos&nbsp;<? echo $classFunction['number']->formatMoney($valorTotalRestante); ?></span>
                <span style="font-size: 10px">Valor das Multas&nbsp;<? echo $classFunction['number']->formatMoney($valorTotalMulta); ?></span>
                <span style="font-size: 10px">Valor dos Juros&nbsp;<? echo $classFunction['number']->formatMoney($valorTotalJuros); ?></span>
                <span style="font-size: 10px">Valor dos Descontos&nbsp;<? echo $classFunction['number']->formatMoney($valorTotalDesconto); ?></span>

            </div>
            <br />
<?
include_once '../report/layout/footer.php';
?>
        </div>
    </body>
</html>
