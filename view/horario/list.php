<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>zebra_pagination/zebra_pagination.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
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
                    <h1>Listar Horários</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri; ?>search">
                                <img src="<?= image ?>icons/zoom.png" />
                                <span>Pesquisar</span>
                            </a>
                        </p>
                    </div>
                    <?
                    include_once '../view/layout/main.php';
                    ?>
                    <div>
                        <?
                        $classFunction['pagination']->render();
                        ?>
                        <table id="mytable" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <td width="360" style="text-align: left; padding-left: 40px" colspan="2">Professor</td>
                                    <td width="50">Inicio</td>
                                    <td width="50">Términ</td>
                                    <td width="40">Turno</td>
                                    <td width="40">Aulas</td>
                                    <td width="80">Dia Semana</td>
                                    <td width="100" style="border-right: none">Sala</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $linha = 0;
                                foreach ($data as $line) {
                                    if ($linha == 0) {
                                        $linha = 1;
                                        ?>
                                        <tr>
                                            <td width="20">
                                                <a href="<?= $uri ?>show/<?php echo $line['dados']['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </td>
                                            <td width="340" style="text-align: left"><?php echo $line['dados']['professor']; ?></td>
                                            <td width="50"><?php echo $line['dados']['inicio']; ?></td>
                                            <td width="50"><?php echo $line['dados']['termino']; ?></td>
                                            <td width="40"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['turno'], $classFunction['turno']->loadOpcoes()); ?></td>
                                            <td width="40"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['aulas'], $classFunction['aulas']->loadOpcoes()); ?></td>
                                            <td width="80"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['dia'], $classFunction['diaSemana']->loadOpcoes()); ?></td>
                                            <td width="100" style="border-right: none"><?php echo $line['dados']['sala']; ?></td>
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
                                            <th width="340" style="text-align: left"><?php echo $line['dados']['professor']; ?></th>
                                            <th width="50"><?php echo $line['dados']['inicio']; ?></th>
                                            <th width="50"><?php echo $line['dados']['termino']; ?></th>
                                            <th width="40"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['turno'], $classFunction['turno']->loadOpcoes()); ?></th>
                                            <th width="40"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['aulas'], $classFunction['aulas']->loadOpcoes()); ?></th>
                                            <th width="80"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['dia'], $classFunction['diaSemana']->loadOpcoes()); ?></th>
                                            <th width="100" style="border-right: none"><?php echo $line['dados']['sala']; ?></th>
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
