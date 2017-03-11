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
                    <h1>Listar Turmas</h1>
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
                                    <td width="100" colspan="2">C&oacute;digo</td>
                                    <td width="200">Grade</td>
                                    <td width="70">Per&iacute;odo</td>
                                    <td width="40">Mód</td>
                                    <td width="40">Turma</td>
                                    <td width="40">Turno</td>
                                    <td width="190" style="border-right: none">Observa&ccedil;&atilde;o</td>
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
                                            <td width="80"><?php echo $line['dados']['codigo']; ?></td>
                                            <td width="200"><?php echo $line['dados']['codGrade'] . " - " . $line['dados']['nomeCurso']; ?></td>
                                            <td width="70"><?php echo $line['dados']['periodo']; ?></td>
                                            <td width="40"><?php echo substr($line['dados']['codigo'], 5, 2); ?></td>
                                            <td width="40"><?php echo substr($line['dados']['codigo'], 7, 2); ?></td>
                                            <td width="40"><?php echo $classFunction['enum']->enumOpcoes(substr($line['dados']['codigo'], 9, 2), $classFunction['turno']->loadOpcoes()); ?></td>
                                            <td width="190" style="border-right: none"><? echo $line['dados']['observacao']; ?></td>
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
                                            <th width="80"><?php echo $line['dados']['codigo']; ?></th>
                                            <th width="200"><?php echo $line['dados']['codGrade'] . " - " . $line['dados']['nomeCurso']; ?></th>
                                            <th width="70"><?php echo $line['dados']['periodo']; ?></th>
                                            <th width="40"><?php echo substr($line['dados']['codigo'], 5, 2); ?></th>
                                            <th width="40"><?php echo substr($line['dados']['codigo'], 7, 2); ?></th>
                                            <th width="40"><?php echo $classFunction['enum']->enumOpcoes(substr($line['dados']['codigo'], 9, 2), $classFunction['turno']->loadOpcoes()); ?></th>
                                            <th width="190" style="border-right: none"><? echo $line['dados']['observacao']; ?></th>
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
