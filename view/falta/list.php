<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
    </head>
    <body>
        <div id="wrapper">
            <?php
            include_once '../view/layout/header.php';
            ?>
            <div id="content">
                <?php
                include_once '../view/layout/menu.php';
                ?>
                <div id="sidebarDir">
                    <h1>Listar Faltas da Disciplina</h1>
                    <div class="submenus">
                        <p>
                            <a href="<? echo application ?>nota/show/<? echo $data['matriculaTurmaDisciplina']['id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                        </p>
                    </div>
                    <?
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-bottom: 10px">
                        <label style="width: 550px">
                            <span class="legenda">Disciplina:</span>
                            <br />
                            <span class="texto"><? echo $data['matriculaTurmaDisciplina']['codDisciplina'] . " - " . $data['matriculaTurmaDisciplina']['disciplina']; ?></span>
                        </label>
                        <label style="width: 150px">
                            <span class="legenda">Período:</span>
                            <br />
                            <span class="texto"><? echo $data['matriculaTurmaDisciplina']['periodo']; ?></span>
                        </label>
                    </div>
                    <div>
                        <table id="mytable" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <td width="250" colspan="2" style="text-align: left; padding-left: 40px">Dia Semana:</td>
                                    <td width="220">Data da Aula</td>
                                    <td width="40">QuanT</td>
                                    <td width="200" style="border-right: none">Situação</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $linha = 0;
                                foreach ($data['faltas'] as $line) {
                                    if ($linha == 0) {
                                        $linha = 1;
                                        ?>
                                        <tr>
                                            <td width="20">
                                                <a href="<?= $uri ?>show/<?php echo $line['dados']['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </td>
                                            <td width="230" style="text-align: left; margin-left: 40px"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['dia'], $classFunction['diaSemana']->loadOpcoes()) ?></td>
                                            <td width="220"><?php echo $classFunction['data']->dataUSAToDataBrasil($line['dados']['data_aula']); ?></td>
                                            <td width="40"><?php echo $line['dados']['valor']; ?></td>
                                            <td width="200" style="border-right: none"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['tipo'], $classFunction['situacaoFalta']->loadOpcoes()); ?></td>
                                        </tr>
                                        <?php
                                    } else {

                                        $linha = 0;
                                        ?>
                                        <tr>
                                            <th width="20">
                                                <a href="<?= $uri ?>show/<?php echo $line['dados']['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </th>
                                            <th width="230" style="text-align: left; margin-left: 40px"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['dia'], $classFunction['diaSemana']->loadOpcoes()) ?></th>
                                            <th width="220"><?php echo $classFunction['data']->dataUSAToDataBrasil($line['dados']['data_aula']); ?></th>
                                            <th width="40"><?php echo $line['dados']['valor']; ?></th>
                                            <th width="200" style="border-right: none"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['tipo'], $classFunction['situacaoFalta']->loadOpcoes()); ?></th>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
    </body>
</html>
