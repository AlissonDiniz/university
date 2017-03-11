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
            include_once '../../report/layout/header.php';
            ?>
            <table align="center" class="tabela" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <td width="80">
                            R.A.
                        </td>
                        <td width="380">
                            Nome
                        </td>
                        <td width="100">
                            CPF
                        </td>
                        <td width="180">
                            E-mail
                        </td>
                        <td width="160" style="border-right: none">
                            Situação
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
                                <? echo $value['dados']['cpf']; ?>
                            </td>
                            <td>
                                <? echo $value['dados']['email']; ?>
                            </td>
                            <td style="border-right: none">
                                <?
                                echo
                                $classFunction['enum']->enumOpcoes($value['dados']['situacao'], $classFunction['situacaoDisciplina']->loadOpcoes());
                                ?>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </tbody>
            </table>
            <div class="legendaFooter">
                <span>N&ordm; de Alunos :&nbsp;<? echo $linhas;    ?></span>
            </div>
            <br />
            <?
            include_once '../../report/layout/footer.php';
            ?>
        </div>
    </body>
</html>
