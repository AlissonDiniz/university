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
                    <strong>Curso: </strong> <? echo $data['grade']['dados']['codigo'] . " - " . $data['grade']['dados']['nome']; ?>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <div style="float: left; width: 200px;">
                        <strong>Período: </strong> <? echo $data['periodo']['dados']['codigo']; ?>
                    </div>
                    <div style="float: left">
                        <strong>Turma:</strong> <?
                        $arrayTurma = explode("-", $data['turma']);
                        echo $arrayTurma[1];
                        ?>
                    </div>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <strong>Disciplina: </strong><? echo $data['turmaDisciplina']['dados']['codDisciplina'] . " - " . $data['turmaDisciplina']['dados']['disciplina']; ?>
                </div>
                <div style="float: left; margin: 5px; width: 900px">
                    <strong>Professor: </strong><? echo $data['turmaDisciplina']['dados']['nomeProfessor']; ?>
                </div>
            </div>
            <table align="center" class="tabela" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <td width="100" style="text-align: center">
                            R.A.
                        </td>
                        <td width="460">
                            Nome
                        </td>
                        <td width="340" style="border-right: none; text-align: center">
                            Assinatura
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
                            <td style="text-align: center">
                                <? echo $value['dados']['matricula']; ?>
                            </td>
                            <td>
                                <? echo $value['dados']['nome']; ?>
                            </td>
                            <td style="border-right: none">&nbsp;</td>
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
