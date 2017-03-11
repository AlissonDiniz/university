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
                    <h1>Listar Títulos</h1>
                    <div class="submenus">
                        <p>
                        </p>
                    </div>
                    <?
                    include_once '../view/layout/main.php';
                    ?>
                    <div>
                        <?
                        $classFunction['pagination']->render();
                        ?>
                        <table id="mytable" cellspacing="0" cellpadding="5" style="margin-top: -10px">
                            <thead>
                                <tr>
                                    <td width="100" colspan="2">Matricula</td>
                                    <td width="500" style="text-align: left; padding-left: 20px">Nome do Aluno:</td>
                                    <td width="80" style="font-size: 0.6em">Nosso Número</td>
                                    <td width="80">Valor</td>
                                    <td width="80" style="font-size: 0.6em">Valor Restante</td>
                                    <td width="80" style="font-size: 0.6em">Vencimento</td>
                                    <td width="80" style="font-size: 0.5em">Situação</td>
                                    <td width="40" style="border-right: none; font-size: 0.5em">Status</td>
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
                                                <a href="<?= $uri ?>showTitulo/<?php echo $line['dados']['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </td>
                                            <td width="80"><?php echo $line['dados']['matricula']; ?></td>
                                            <td width="300" style="text-align: left"><?php echo $line['dados']['nome']; ?></td>
                                            <td width="80"><?php echo $line['dados']['nosso_numero']; ?></td>
                                            <td width="80"><?php echo $classFunction["number"]->formatMoney($line['dados']['valor']); ?></td>
                                            <td width="80"><?php echo $classFunction["number"]->formatMoney($line['dados']['valor_restante']); ?></td>
                                            <td width="80"><?php echo $classFunction["data"]->dataUSAToDataBrasil($line['dados']['vencimento']); ?></td>
                                            <td width="80"><?php echo $classFunction["enum"]->enumOpcoes($line['dados']['situacao'], $classFunction["situacaoTitulo"]->loadOpcoes()); ?></td>
                                            <td width="80" style="border-right: none"><?php echo $classFunction["enum"]->enumStatus($line['dados']['status']); ?></td>
                                        </tr>

                                        <?php
                                    } else {

                                        $linha = 0;
                                        ?>
                                        <tr>
                                            <th width="20">
                                                <a href="<?= $uri ?>showTitulo/<?php echo $line['dados']['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </th>
                                            <th width="80"><?php echo $line['dados']['matricula']; ?></th>
                                            <th width="300" style="text-align: left"><?php echo $line['dados']['nome']; ?></th>
                                            <th width="80"><?php echo $line['dados']['nosso_numero']; ?></th>
                                            <th width="80"><?php echo $classFunction["number"]->formatMoney($line['dados']['valor']); ?></th>
                                            <th width="80"><?php echo $classFunction["number"]->formatMoney($line['dados']['valor_restante']); ?></th>
                                            <th width="80"><?php echo $classFunction["data"]->dataUSAToDataBrasil($line['dados']['vencimento']); ?></th>
                                            <th width="80"><?php echo $classFunction["enum"]->enumOpcoes($line['dados']['situacao'], $classFunction["situacaoTitulo"]->loadOpcoes()); ?></th>
                                            <th width="80" style="border-right: none"><?php echo $classFunction["enum"]->enumStatus($line['dados']['status']); ?></th>
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
