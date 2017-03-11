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
        <link rel="stylesheet" type="text/css" href="<?php echo css ?>report/main.css" />
        <link rel="shortcut icon" href="<?php echo image ?>logos/favico.png" />
        <title>Relatório do <?php echo name ?></title>
    </head>
    <body>
        <div class="corpo">
            <?php
                include_once '../report/layout/header.php';
            ?>
            <div style="float: left; width: 100%; text-align: left; font-size: 0.9em; margin: -10px 0 20px 0">
                <div style="float: left; margin: 5px; width: 900px">
                    <strong>Estrutura Curricular: </strong> <?php echo $data['grade']['dados']['codigo'] . " - " . $data['grade']['dados']['nome']; ?>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <div style="float: left; width: 200px;">
                        <strong>Período: </strong> <?php echo $data['periodo']['dados']['codigo']; ?>
                    </div>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <div style="float: left">
                        <strong>Turma:</strong> <?php echo $data['turma']['dados']['codigo'] . " - " . $data['turma']['dados']['observacao']; ?>
                    </div>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <strong>Forma de Pagamento: </strong> <?php echo $data['formaPagamento']['dados']['descricao']; ?>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <strong>De Pagamento: </strong><?php echo $data['dataPagamentoInit'] . " <strong>à</strong> " . $data['dataPagamentoEnd']; ?>
                </div>
            </div>
            <table align="center" class="tabela" cellpadding="5" cellspacing="0">
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
                            Valor Pago
                        </td>
                        <td width="80" style="text-align: center">
                            Data Pagamento
                        </td>
                        <td width="80" style="text-align: center">
                            Forma Pagamento
                        </td>
                        <td width="60" style="text-align: center">
                            Data Operação
                        </td>
                        <td width="150" style="border-right: none">
                            Usuário Operação
                        </td>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $linhas = 0;
                    $valorTotal = 0;
                    foreach ($data['result'] as $value) {
                        $linhas++;
                        ?>
                        <tr>
                            <td style="text-align: center">
                                <?php echo $value['dados']['nosso_numero']; ?>
                            </td>
                            <td style="text-align: center">
                                <?php echo $value['dados']['matricula']; ?>
                            </td>
                            <td>
                                <?php echo $value['dados']['nome'] . "<br />" . $value['dados']['cpf']; ?>
                            </td>
                            <td style="text-align: left">
                                <?php $valorTotal = $valorTotal + $value['dados']['valor_pago'];
                                echo $classFunction['number']->formatMoney($value['dados']['valor_pago']);
                                ?>
                            </td>
                            <td style="text-align: center">
                                <?php echo $classFunction['data']->dataUSAToDataBrasil($value['dados']['data_pagamento']); ?>
                            </td>
                            <td style="text-align: center">
                                <?php echo $value['dados']['formaPagamento']; ?>
                            </td>
                            <td style="text-align: center">
                                <?php echo $classFunction['data']->dataUSAToDataHoraBrasil($value['dados']['data']); ?>
                            </td>
                            <td style="border-right: none">
                                <?php echo $value['dados']['userName']; ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="legendaFooter">
                <span>N&ordm; de Linhas :&nbsp;<?php echo $linhas; ?></span>
                <span>Valor total das Baixas&nbsp;<?php echo $classFunction['number']->formatMoney($valorTotal); ?></span>
            </div>
            <br />
            <?php
                include_once '../report/layout/footer.php';
            ?>
        </div>
    </body>
</html>
