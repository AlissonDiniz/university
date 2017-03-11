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
            <div style="float: left; font-size: 12px; color: #333; margin: -10px 0 10px 10px; text-align: left; line-height: 200%">
                <div style="float: left; width: 100%">
                    <div style="float: left; width: 200px">
                        <span style="font-weight: bold">Arquivo:</span>
                    </div>
                    <span style="color: #0000FF; margin-left: 5px; line-height: 150%"><? echo $data['arquivo']['dados']['nome']; ?></span>
                </div>
                <div style="float: left; width: 100%">
                    <div style="float: left; width: 200px">
                        <span style="font-weight: bold">Data do Processamento:</span>
                    </div>
                    <span style="color: #0000FF; margin-left: 5px; line-height: 150%"><? echo $classFunction['data']->dataUSAToDataHoraBrasil($data['arquivo']['dados']['data']); ?></span>
                </div>
                <div style="float: left; width: 100%">
                    <div style="float: left; width: 200px">
                        <span style="font-weight: bold">Usuário Operador:</span>
                    </div>
                    <span style="color: #0000FF; margin-left: 5px; line-height: 150%"><? echo $data['arquivo']['dados']['usuario']; ?></span>
                </div>
                <div style="float: left; width: 100%">
                    <div style="float: left; width: 200px">
                        <span style="font-weight: bold">Descrição:</span>
                    </div>
                    <div style="float: left; width: 500px">
                        <span style="color: #0000FF; margin-left: 5px; line-height: 150%"><? echo $data['arquivo']['dados']['descricao']; ?></span>
                    </div>
                </div>
            </div>
            <table align="center" class="tabela" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <td width="80" style="text-align: center; font-size: 9px">
                            Nosso Número
                        </td>
                        <td style="text-align: center">
                            Matricula
                        </td>
                        <td width="320">
                            Nome
                        </td>
                        <td width="80" style="text-align: center">
                            Valor Pago
                        </td>
                        <td width="80" style="text-align: left">
                            Usuário Operação
                        </td>
                        <td width="80" style="text-align: left">
                            Data Ocorrência
                        </td>
                        <td width="260" style="border-right: none">
                            Descrição Ocorrência
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
                            <td style="text-align: center; font-size: 9px">
                                <? echo $value['dados']['nosso_numero']; ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $value['dados']['matricula']; ?>
                            </td>
                            <td style="font-size: 10px">
                                <? echo $value['dados']['nome'] . "<br />" . $value['dados']['cpf']; ?>
                            </td>
                            <td style="text-align: left">
                                <?
                                $valorTotal = $valorTotal + $value['dados']['valor_pago'];
                                echo $classFunction['number']->formatMoney($value['dados']['valor_pago']);
                                ?>
                            </td>
                            <td>
                                <? echo $value['dados']['usuario']; ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction['data']->dataUSAToDataHoraBrasil($value['dados']['data_ocorrencia']); ?>
                            </td>
                            <td style="border-right: none; font-size: 9px">
                                <? echo $value['dados']['descricao_ocorrencia']; ?>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </tbody>
            </table>
            <div class="legendaFooter">
                <span>N&ordm; de Linhas :&nbsp;<? echo $linhas; ?></span>
                <span>Valor total das Ocorrências&nbsp;<? echo $classFunction['number']->formatMoney($valorTotal); ?></span>
            </div>
            <br />
            <?
            include_once '../report/layout/footer.php';
            ?>
        </div>
    </body>
</html>
