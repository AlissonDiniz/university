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
            <div style="float: left; width: 100%; text-align: left; font-size: 0.9em; margin: -10px 0 20px 0">
                <div style="float: left; margin: 5px; width: 900px">
                    <strong>Forma de Pagamento: </strong> <? echo $data['formaPagamento']['dados']['descricao']; ?>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <strong>Usuários: </strong> <? echo $data['usuario']['dados']['nome']; ?>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <strong>De Pagamento: </strong><? echo $data['dataPagamentoInit'] . " <strong>à</strong> " . $data['dataPagamentoEnd']; ?>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <strong>De Operação: </strong><? echo $data['dataOperacaoInit'] . " <strong>à</strong> " . $data['dataOperacaoEnd']; ?>
                </div>
            </div>
            <table align="center" class="tabela" cellpadding="5" cellspacing="0" style="width: 1100px">
                <thead>
                    <tr>
                        <td style="text-align: center; font-size: 9px">
                            Nosso Número
                        </td>
                        <td style="text-align: center">
                            Matricula
                        </td>
                        <td width="380">
                            Nome
                        </td>
                        <td width="120" style="text-align: center">
                            Valor do Título
                        </td>
                        <td width="120" style="text-align: center">
                            Valor Pago
                        </td>
                        <td width="80" style="text-align: center">
                            Data Pagamento
                        </td>
                        <td width="80" style="text-align: center">
                            Forma Pagamento
                        </td>
                        <td width="80" style="text-align: center">
                            Data Operação
                        </td>
                        <td width="100">
                            Usuário Operação
                        </td>
                        <td width="80" style="text-align: center">
                            Data Alteração
                        </td>
                        <td width="100" style="border-right: none">
                            Usuário Alteração
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
                                <? echo $classFunction['number']->formatMoney($value['dados']['valor']); ?>
                            </td>
                            <td style="text-align: left">
                                <?
                                $valorTotal = $valorTotal + $value['dados']['valor_pago'];
                                echo $classFunction['number']->formatMoney($value['dados']['valor_pago']);
                                ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction['data']->dataUSAToDataBrasil($value['dados']['data_pagamento']); ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $value['dados']['formaPagamento']; ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction['data']->dataUSAToDataHoraBrasil($value['dados']['data']); ?>
                            </td>
                            <td>
                                <? echo $value['dados']['userName']; ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction['data']->dataUSAToDataHoraBrasil($value['dados']['data_update']); ?>
                            </td>
                            <td style="border-right: none">
                                <? echo $value['dados']['userNameUpdate']; ?>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </tbody>
            </table>
            <div class="legendaFooter">
                <span>N&ordm; de Linhas :&nbsp;<? echo $linhas; ?></span>
                <span>Valor total das Baixas&nbsp;<? echo $classFunction['number']->formatMoney($valorTotal); ?></span>
            </div>
            <br />
            <?
            include_once '../report/layout/footer.php';
            ?>
        </div>
    </body>
</html>
