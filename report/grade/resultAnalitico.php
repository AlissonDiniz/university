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
            $grades = 0;
            $modulos = 0;
            $modulosDisciplina = 0;
            foreach ($data['result'] as $value) {
                $grades++;
                ?>
                <table align="center" class="tabela" cellpadding="5" cellspacing="0">
                    <thead>
                        <tr>
                            <td width="110" style="text-align: center">Código</td>
                            <td width="420">Nome do Curso</td>
                            <td width="100" style="text-align: center">Carga H</td>
                            <td width="110" style="text-align: center">Inicio</td>
                            <td width="110" style="text-align: center">Término</td>
                            <td width="90" style="border-right: none; text-align: center">Status</td>
                        </tr>
                    </thead>
                    <tbody>        
                        <tr>
                            <td style="text-align: center">
                                <? echo $value['dados']['codigo']; ?>
                            </td>
                            <td>
                                <? echo $value['dados']['nome']; ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction['number']->formatNumber($value['dados']['carga_horaria']); ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction['data']->dataUSAToDataBrasil($value['dados']['inicio']); ?>
                            </td>
                            <td style="text-align: center">
                                <? echo $classFunction['data']->dataUSAToDataBrasil($value['dados']['termino']); ?>
                            </td>
                            <td style="border-right: none; text-align: center">
                                <? echo $classFunction['enum']->enumStatus($value['dados']['status']); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?
                foreach ($value['dados']['modulo'] as $linha) {
                    $modulos++;
                    ?>
                    <table align="center" class="tabela" cellpadding="5" cellspacing="0" style="margin-bottom: 10px">
                        <thead>
                            <tr>
                                <td width="900" colspan="5" style="border-right: none; text-align: center"><? echo $linha['dados']['descricao']; ?></td>
                            </tr>
                        </thead>
                    </table>
                    <?
                    foreach ($linha['dados']['moduloDisciplina'] as $line) {
                        $modulosDisciplina++;
                        ?>
                        <table align="center" class="tabela" cellpadding="5" cellspacing="0" style="margin-top: 10px">
                            <tbody>
                                <tr>
                                    <td width="100" style="text-align: center"><? echo $line['dados']['codigo']; ?></td>
                                    <td width="400"><? echo $line['dados']['nome']; ?></td>
                                    <td width="100" style="text-align: center"><? echo $line['dados']['carga_horaria']; ?></td>
                                    <td width="100" style="border-right: none; text-align: center"><? echo $classFunction['enum']->enumObrigatorio($line['dados']['obrigatorio']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <?
                    }
                }
                ?>
                <div class="legendaFooter">
                    <span>N&ordm; de Módulos :&nbsp;<? echo $modulos; ?></span> <span>N&ordm; de Disciplinas :&nbsp;<? echo $modulosDisciplina; ?></span>
                </div>
                <br />
                <br />
                <br />
                <?
                $modulos = 0;
                $modulosDisciplina = 0;
            }
            ?>
            <div class="legendaFooter">
                <span>N&ordm; de Estruturas Curriculares :&nbsp;<? echo $grades; ?></span>
            </div>
            <br />
            <?
            include_once '../report/layout/footer.php';
            ?>
        </div>
    </body>
</html>
