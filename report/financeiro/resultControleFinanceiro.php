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
                    <strong>Estrutura Curricular: </strong> <? echo $data['grade']['dados']['codigo'] . " - " . $data['grade']['dados']['nome']; ?>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <div style="float: left; width: 200px;">
                        <strong>Período: </strong> <? echo $data['periodo']['dados']['codigo']; ?>
                    </div>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <div style="float: left">
                        <strong>Turma:</strong> <? echo $data['turma']['dados']['codigo'] . " - " . $data['turma']['dados']['observacao']; ?>
                    </div>
                </div>
            </div>
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
                        <td width="60" style="text-align: center">
                            Status
                        </td>
                        <td width="100" style="text-align: center">
                            Data Pagamento
                        </td>
                        <td width="120" style="text-align: center; border-right: none">
                            Forma Pagamento
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $linhas = 0;
                    $arrayAluno = array();
                    $titulos = array();
                    $titulosVencido = array();
                    $titulosVencidoTotal = 0;
                    foreach ($data['result'] as $value) {
                        $linhas++;
                        ?>
                        <tr>
                            <td style="text-align: center">
                                <?
                                if (!in_array($value['dados']['nosso_numero'], $titulos)) {
                                    $titulos[] = $value['dados']['nosso_numero'];
                                }
                                if (!in_array($value['dados']['nosso_numero'], $titulosVencido)) {
                                    if ($value['dados']['situacao'] == "V") {
                                        $titulosVencidoTotal = $titulosVencidoTotal + $value['dados']['valor_restante'];
                                        $titulosVencido[] = $value['dados']['nosso_numero'];
                                    }
                                }
                                echo $value['dados']['nosso_numero'];
                                ?>
                            </td>
                            <td style="text-align: center">
                                <?
                                if (!in_array($value['dados']['matricula'], $arrayAluno)) {
                                    $arrayAluno[] = $value['dados']['matricula'];
                                }
                                echo $value['dados']['matricula'];
                                ?>
                            </td>
                            <td>
                                <? echo $value['dados']['nome'] . "<br />" . $value['dados']['cpf']; ?>
                            </td>
                            <td>
                                <? echo $value['dados']['parcela']; ?>
                            </td>
                            <td style="text-align: left">
                                <? echo $classFunction['number']->formatMoney($value['dados']['valor']); ?>
                            </td>
                            <td style="text-align: left">
                                <?
                                echo $classFunction['number']->formatMoney($value['dados']['valor_restante']);
                                ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction["data"]->dataUSAToDataBrasil($value['dados']['vencimento']); ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction["enum"]->enumOpcoes($value['dados']['situacao'], $classFunction["situacaoTitulo"]->loadOpcoes()); ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction['enum']->enumStatus($value['dados']['status']); ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction["data"]->dataUSAToDataBrasil($value['dados']['dataPagamento']); ?>
                            </td>
                            <td style="text-align: center; border-right: none">
                                <? echo $value['dados']['formaPagamento']; ?>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </tbody>
            </table>
            <div class="legendaFooter">
                <span>N&ordm; de Alunos :&nbsp;<? echo count($arrayAluno); ?></span>
                <span>N&ordm; de Títulos :&nbsp;<? echo count($titulos); ?></span>
                <span>N&ordm; de Títulos Vencidos :&nbsp;<? echo count($titulosVencido); ?></span>
                <span>Valor total restante vencido:&nbsp;<? echo $classFunction['number']->formatMoney($titulosVencidoTotal); ?></span>
            </div>
            <br />
            <?
            include_once '../report/layout/footer.php';
            ?>
        </div>
    </body>
</html>
