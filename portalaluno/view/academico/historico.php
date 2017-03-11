<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>zebra_pagination/zebra_pagination.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "list.css" ?>" />
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
                    <h1>Histórico</h1>
                    <div class="submenus">
                        <p>
                        </p>
                    </div>
                    <?
                    include_once '../view/layout/main.php';
                    ?>
                    <div>
                        <table id="mytable" cellspacing="0" cellpadding="5" style="margin-top: -10px">
                            <thead>
                                <tr>
                                    <td width="100" colspan="2">Período</td>
                                    <td width="80">Cód Disciplina</td>
                                    <td width="500">Nome Disciplina</td>
                                    <td width="80">CH</td>
                                    <td width="80">Média</td>
                                    <td width="40" style="border-right">Situação</td>
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
                                            <td width="100"><?php echo $line['dados']['periodo']; ?></td>
                                            <td width="80"><?php echo $line['dados']['codigo']; ?></td>
                                            <td width="500"><?php $line['dados']['nome']; ?></td>
                                            <td width="80"><?php echo $line['dados']['carga_horaria']; ?></td>
                                            <td width="80"><?php echo $line['dados']['resultado_final'] . $line['dados']['conceito']; ?></td>
                                            <td width="80" style="border-right: none"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['situacao'], $classFunction['situacaoDisciplina']->loadOpcoes()); ?></td>
                                        </tr>

                                        <?php
                                    } else {

                                        $linha = 0;
                                        ?>
                                        <tr>
                                            <th width="100"><?php echo $line['dados']['periodo']; ?></th>
                                            <th width="80"><?php echo $line['dados']['codigo']; ?></th>
                                            <th width="500"><?php $line['dados']['nome']; ?></th>
                                            <th width="80"><?php echo $line['dados']['carga_horaria']; ?></th>
                                            <th width="80"><?php echo $line['dados']['resultado_final'] . $line['dados']['conceito']; ?></th>
                                            <th width="80" style="border-right: none"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['situacao'], $classFunction['situacaoDisciplina']->loadOpcoes()); ?></th>
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
