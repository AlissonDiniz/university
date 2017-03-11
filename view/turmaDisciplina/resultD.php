<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "list.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
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
                    <h1>Resultado da Busca</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri; ?>searchD">
                                <img src="<?= image ?>icons/zoom.png" />
                                <span>Pesquisar</span>
                            </a>
                        </p>
                    </div>
                    <?
                    include_once '../view/layout/main.php';
                    ?>
                    <div>
                        <table id="mytable" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <td width="240" colspan="2">Disciplina</td>
                                    <td width="80">Inicio</td>
                                    <td width="80">Termino</td>
                                    <td width="40">Vagas</td>
                                    <td width="50" style="border-right: none">Status</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $linha = 0;
                                foreach ($data['turmaDisciplina'] as $line) {
                                    if ($linha == 0) {
                                        $linha = 1;
                                        ?>
                                        <tr>
                                            <td width="20">
                                                <a href="<?= $uri ?>show/<?php echo $line['dados']['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </td>
                                            <td width="220" style="text-align: left"><?php echo $line['dados']['codDisciplina'] . " - " . $line['dados']['disciplina']; ?></td>
                                            <td width="80"><?php echo $classFunction['data']->dataUSAToDataBrasil($line['dados']['inicio']); ?></td>
                                            <td width="80"><?php echo $classFunction['data']->dataUSAToDataBrasil($line['dados']['termino']); ?></td>
                                            <td width="50"><?php echo $line['dados']['vagas']; ?></td>
                                            <td width="40" style="border-right: none"><? echo $classFunction['enum']->enumStatus($line['dados']['status']); ?></td>
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
                                            <th width="220" style="text-align: left"><?php echo $line['dados']['codDisciplina'] . " - " . $line['dados']['disciplina']; ?></th>
                                            <th width="80"><?php echo $classFunction['data']->dataUSAToDataBrasil($line['dados']['inicio']); ?></th>
                                            <th width="80"><?php echo $classFunction['data']->dataUSAToDataBrasil($line['dados']['termino']); ?></th>
                                            <th width="50"><?php echo $line['dados']['vagas']; ?></th>
                                            <th width="40" style="border-right: none"><? echo $classFunction['enum']->enumStatus($line['dados']['status']); ?></th>
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
