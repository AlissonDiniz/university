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
                            <a href="<?= $uri; ?>list">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
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
                        <table id="mytable" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <td width="140" colspan="2">Per&iacute;odo</td>
                                    <td width="60">R.A.</td>
                                    <td width="400" style="text-align: left; padding-left: 40px">Nome:</td>
                                    <td width="100">Situação</td>
                                    <td width="60" style="border-right: none">Status</td>
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
                                            <td width="120"><?php echo $line['dados']['periodo']; ?></td>
                                            <td width="60"><?php echo $line['dados']['matricula']; ?></td>
                                            <td width="400" style="text-align: left"><?php echo $line['dados']['nome']; ?></td>
                                            <td width="100"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['situacao'], $classFunction['situacaoPeriodo']->loadOpcoes()); ?></td>
                                            <td width="60" style="border-right: none"><?php echo $classFunction['enum']->enumStatus($line['dados']['status']); ?></td>
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
                                            <th width="120"><?php echo $line['dados']['periodo']; ?></th>
                                            <th width="60"><?php echo $line['dados']['matricula']; ?></th>
                                            <th width="400" style="text-align: left"><?php echo $line['dados']['nome']; ?></th>
                                            <th width="100"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['situacao'], $classFunction['situacaoPeriodo']->loadOpcoes()); ?></th>
                                            <th width="60" style="border-right: none"><?php echo $classFunction['enum']->enumStatus($line['dados']['status']); ?></th>
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
