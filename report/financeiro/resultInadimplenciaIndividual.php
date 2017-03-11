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
                    <div style="float: left; width: 200px;">
                        <strong>CPF: </strong> <? echo $data['cpf']; ?>
                    </div>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <strong>Nome: </strong> <? echo $data['nome']; ?>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <div style="float: left">
                        <strong>Matricula:</strong> <? echo $data['matricula']; ?>
                    </div>
                </div>
            </div>
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
                        <td width="40" style="text-align: center">
                            Parc
                        </td>
                        <td width="100" style="text-align: center">
                            Valor
                        </td>
                        <td width="100" style="text-align: center">
                            Valor restante
                        </td>
                        <td width="100" style="text-align: center">
                            Data Vencimento
                        </td>
                        <td width="100" style="text-align: center">
                            Situação
                        </td>
                        <td width="60" style="text-align: center; border-right: none">
                            Status
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $linhas = 0;
                    $valorTotal = 0;
                    $valorTotalRestante = 0;
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
                            <td>
                                <? echo $value['dados']['parcela']; ?>
                            </td>
                            <td style="text-align: left">
                                <?
                                $valorTotal = $valorTotal + $value['dados']['valor'];
                                echo $classFunction['number']->formatMoney($value['dados']['valor']);
                                ?>
                            </td>
                            <td style="text-align: left">
                                <?
                                $valorTotalRestante = $valorTotalRestante + $value['dados']['valor_restante'];
                                echo $classFunction['number']->formatMoney($value['dados']['valor_restante']);
                                ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction["data"]->dataUSAToDataBrasil($value['dados']['vencimento']); ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction["enum"]->enumOpcoes($value['dados']['situacao'], $classFunction["situacaoTitulo"]->loadOpcoes()); ?>
                            </td>
                            <td style="text-align: center; border-right: none">
                                <? echo $classFunction['enum']->enumStatus($value['dados']['status']); ?>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </tbody>
            </table>
            <div class="legendaFooter">
                <span>N&ordm; de Linhas :&nbsp;<? echo $linhas; ?></span>
                <span>Valor total:&nbsp;<? echo $classFunction['number']->formatMoney($valorTotal); ?></span>
                <span>Valor total restante:&nbsp;<? echo $classFunction['number']->formatMoney($valorTotalRestante); ?></span>
            </div>
            <br />
            <?
            include_once '../report/layout/footer.php';
            ?>
        </div>
    </body>
</html>
