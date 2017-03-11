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
        <link rel="stylesheet" type="text/css" href="<?= css ?>aluno/historico.css" />
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title>Relatório do <?= name ?></title>
    </head>
    <body>
        <div class="corpo">
            <?
            include_once '../report/layout/header.php';
            ?>
            <div>
                <table class="table" cellspacing="3" cellpadding="3">
                    <tr>
                        <th width="110">Nome Aluno:</th>
                        <td><? echo $data['cabecalho']['dados']['nome']; ?></td>
                    </tr>
                </table>
                <table class="table" cellspacing="3" cellpadding="3">
                    <tr>
                        <th width="110">CPF:</th>
                        <td width="440"><? echo $data['cabecalho']['dados']['cpf']; ?></td>
                        <th width="120">RG + &Oacute;rg&atilde;o:</th>
                        <td width="130"><? echo $data['cabecalho']['dados']['identidade'] . " / " . $data['cabecalho']['dados']['orgao_emissor_identidade'] . "-" . $data['cabecalho']['dados']['estado_identidade']; ?></td>
                    </tr>
                    <tr>
                        <th width="110" align="left">Matricula:</th>
                        <td width="440"><? echo $data['cabecalho']['dados']['matricula']; ?></td>
                        <th width="120" align="left">Per&iacute;odo Ingresso:</th>
                        <td width="130"><? echo $data['cabecalho']['dados']['periodoIngresso']; ?></td>
                    </tr>
                    <tr>
                        <th width="110">Curso:</th>
                        <td width="440"><? echo $data['cabecalho']['dados']['codigoCurso'] . " - " . $data['cabecalho']['dados']['nomeCurso']; ?></td>
                        <th width="120">Forma Ingresso:</th>
                        <td width="130"><? echo $classFunction['enum']->enumOpcoes($data['cabecalho']['dados']['forma_ingresso'], $classFunction['formaIngresso']->loadOpcoes()); ?></td>
                    </tr>
                </table>
                <table class="table" cellspacing="3" cellpadding="3">
                    <tr>
                        <th width="110">Observação:</th>
                        <td><? echo $data['cabecalho']['dados']['observacao']; ?></td>
                    </tr>
                </table>
            </div>
            <table align="center" class="tabela" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <td width="60" style="text-align: center">
                            Período
                        </td>
                        <td width="80" style="text-align: center">
                            Cód Disciplina
                        </td>
                        <td width="450">
                            Nome Disciplina
                        </td>
                        <td width="40" style="text-align: center">
                            CH
                        </td>
                        <td width="40" style="text-align: center">
                            Média
                        </td>
                        <td width="100" style="border-right: none; text-align: center">
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
                                <td style="text-align: center">
                                    <? echo $value['dados']['carga_horaria']; ?>
                                </td>
                                <td style="text-align: center">
                                    <? echo $value['dados']['resultado_final'] . $value['dados']['conceito']; ?>
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
                                <th style="text-align: center">
                                    <? echo $value['dados']['carga_horaria']; ?>
                                </th>
                                <th style="text-align: center">
                                    <? echo $value['dados']['resultado_final'] . $value['dados']['conceito']; ?>
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
            <div>
                <table class="table" cellspacing="3" cellpadding="3">
                    <tr>
                        <th width="200">Carga Horária Curso:</th>
                        <td width="300"><? echo $classFunction['number']->formatCarga($data['cabecalho']['dados']['carga_horaria']); ?></td>
                        <th width="200">CRE:</th>
                        <td width="100"><? echo $classFunction['number']->formatCRE($data['cabecalho']['dados']['cre']); ?></td>
                    </tr>
                    <tr>
                        <th width="200">Carga Horária Acumulada:</th>
                        <td width="300"><? echo $classFunction['number']->formatCarga($data['cabecalho']['dados']['carga_horaria_acumulada']); ?></td>
                        <th width="200">Atividades Complementares:</th>
                        <td width="100"><? echo $classFunction['enum']->enumAtividades($data['cabecalho']['dados']['status_atividade']); ?></td>
                    </tr>
                </table>
                <table class="table" cellspacing="3" cellpadding="3">
                    <tr>
                        <th width="80">Enade:</th>
                        <td><? echo $data['cabecalho']['dados']['observacao']; ?></td>
                    </tr>
                </table>
            </div>
            <br />
            <?
            include_once '../report/layout/footer.php';
            ?>
        </div>
    </body>
</html>
