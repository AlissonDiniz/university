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
                    <h1>Listar Observação</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri; ?>create">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Cadastrar</span>
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
                        <?
                        $classFunction['pagination']->render();
                        ?>
                        <table id="mytable" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <td width="380" style="text-align: left; padding-left: 40px" colspan="2">Nome</td>
                                    <td width="220">Descrição:</td>
                                    <td width="100">Origem</td>
                                    <td width="40" style="border-right: none">Status</td>
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
                                            <td width="360" style="text-align: left"><?php echo $line['dados']['nome']; ?></td>
                                            <td width="220" style="text-align: left"><?php echo $line['dados']['descricao']; ?></td>
                                            <td width="160"><? echo $classFunction['enum']->enumOpcoes($line['dados']['origem'], $classFunction['origem']->loadOpcoes()); ?></td>
                                            <td width="40" style="border-right: none"><?php echo $classFunction['enum']->enumStatus($line['dados']['status']); ?></td>
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
                                            <th width="360" style="text-align: left"><?php echo $line['dados']['nome']; ?></th>
                                            <th width="220" style="text-align: left"><?php echo $line['dados']['descricao']; ?></th>
                                            <th width="160"><? echo $classFunction['enum']->enumOpcoes($line['dados']['origem'], $classFunction['origem']->loadOpcoes()); ?></th>
                                            <th width="40" style="border-right: none"><?php echo $classFunction['enum']->enumStatus($line['dados']['status']); ?></th>
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
