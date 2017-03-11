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
                    <strong>Estrutura Curricular: </strong> <? echo $data['grade']['dados']['codigo'] . " - " . $data['grade']['dados']['nome']; ?>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <div style="float: left; width: 200px;">
                        <strong>Período: </strong> <? echo $data['periodo']['dados']['codigo']; ?>
                    </div>
                    <div style="float: left">
                        <strong>Turma:</strong> <? echo $data['turma']; ?>
                    </div>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <strong>De: </strong><? echo $data['dataInicial'] . " <strong>à</strong> " . $data['dataFinal']; ?>
                </div>
            </div>
            <table align="center" class="tabela" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <td width="80" style="text-align: center">
                            R.A.
                        </td>
                        <td width="310">
                            Nome
                        </td>
                        <td width="220">
                            Curso
                        </td>
                        <td width="70">
                            Turma
                        </td>
                        <td width="100" style="text-align: center">
                            Situação
                        </td>
                        <td width="100" style="border-right: none; text-align: center">
                            Data
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
                                <? echo $value['dados']['nomeCurso']; ?>
                            </td>
                            <td>
                                <? echo $value['dados']['turma']; ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction['enum']->enumOpcoes($value['dados']['situacao'], $classFunction['situacaoPeriodo']->loadOpcoes()); ?>
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
                <span>N&ordm; de Alunos :&nbsp;<? echo $linhas; ?></span>
            </div>
            <br />
            <?
            include_once '../report/layout/footer.php';
            ?>
        </div>
    </body>
</html>
