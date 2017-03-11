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
            <div style="float: left; width: 100%; text-align: left; font-size: 12px; margin: -10px 0 20px 0">
                <div style="float: left; margin: 5px; width: 900px">
                    <div style="float: left; width: 700px">
                        <strong>Aluno: </strong> <? echo $data['cabecalho']['dados']['nome']; ?>
                    </div>
                    <div style="float: left; width: 170px">
                        <strong>CPF: </strong> <? echo $data['cabecalho']['dados']['cpf']; ?>
                    </div>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <div style="float: left; width: 220px">
                        <strong>Código Curso:</strong> <? echo $data['cabecalho']['dados']['curso']; ?>
                    </div>
                    <div style="float: left; width: 680px">
                        <strong>Nome Curso:</strong> <? echo $data['cabecalho']['dados']['nomeCurso']; ?>
                    </div>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <div style="float: left; width: 220px">
                        <strong>Turma:</strong> <? echo $data['cabecalho']['dados']['turma']; ?>
                    </div>
                    <div style="float: left; width: 200px">
                        <strong>Turno:</strong> <? echo $classFunction['enum']->enumOpcoes($data['cabecalho']['dados']['turno'], $classFunction['turno']->loadOpcoes()); ?>
                    </div>
                    <div style="float: left; width: 200px">
                        <strong>Período:</strong> <? echo $data['cabecalho']['dados']['periodo']; ?>
                    </div>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <div style="float: left; width: 600px">
                        <strong>Situação no Período:</strong> <? echo $classFunction['enum']->enumOpcoes($data['cabecalho']['dados']['situacao'], $classFunction['situacaoPeriodo']->loadOpcoes()); ?>
                    </div>
                </div>

            </div>
            <table align="center" class="tabela" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <td width="100" style="text-align: center">
                            Período
                        </td>
                        <td width="150" style="text-align: center">
                            Cód Disciplina
                        </td>
                        <td width="640">
                            Nome Disciplina
                        </td>
                        <td width="150" style="border-right: none; text-align: center">
                            Situação
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $linhas = 0;
                    $line = 0;
                    foreach ($data['result'] as $value) {
                        $linhas++;
                        if ($line == 0) {
                            $line = 1;
                            ?>                    
                            <tr>
                                <td style="text-align: center">
                                    <? echo $value['dados']['periodo']; ?>
                                </td>
                                <td style="text-align: center">
                                    <? echo $value['dados']['codigo']; ?>
                                </td>
                                <td>
                                    <? echo $value['dados']['nome']; ?>
                                </td>
                                <td style="border-right: none; text-align: center">
                                    <? echo $classFunction['enum']->enumOpcoes($value['dados']['situacao'], $classFunction['situacaoDisciplina']->loadOpcoes()); ?>
                                </td>
                            </tr>
                            <?
                        } else {
                            $line = 0;
                            ?>
                            <tr>
                                <th style="text-align: center">
                                    <? echo $value['dados']['periodo']; ?>
                                </th>
                                <th style="text-align: center">
                                    <? echo $value['dados']['codigo']; ?>
                                </th>
                                <th>
                                    <? echo $value['dados']['nome']; ?>
                                </th>
                                <th style="border-right: none; text-align: center">
                                    <? echo $classFunction['enum']->enumOpcoes($value['dados']['situacao'], $classFunction['situacaoDisciplina']->loadOpcoes()); ?>
                                </th>
                            </tr>
                            <?
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class="legendaFooter">
                <span>N&ordm; de Disciplinas :&nbsp;<? echo $linhas; ?></span>
            </div>
            <div class="legendaFooter" style="text-align: right; margin: 20px 0 20px 0">
                ___________________________________________
                <br />
                <span style="margin-right: 120px">Assinatura da coordenação</span>
            </div>
            <br />
            <?
            include_once '../report/layout/footer.php';
            ?>
        </div>
    </body>
</html>
