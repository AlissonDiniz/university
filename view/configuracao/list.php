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
                    <h1>Listar Configurações Bancárias</h1>
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
                                    <td width="80" colspan="2">Banco</td>
                                    <td width="300" style="text-align: left; padding-left: 40px">Nome do Banco:</td>
                                    <td width="80" style="font-size: 0.6em">Agência</td>
                                    <td width="80" style="font-size: 0.6em">Conta Corrente</td>
                                    <td width="60" style="font-size: 0.6em">Carteira</td>
                                    <td width="60" style="font-size: 0.6em">Convênio</td>
                                    <td width="60" style="border-right: none; font-size: 0.6em">Operação</td>
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
                                            <td width="60"><?php echo $line['dados']['banco']; ?></td>
                                            <td width="300" style="text-align: left"><?php echo $line['dados']['nome_banco']; ?></td>
                                            <td width="80"><?php echo $line['dados']['agencia']; ?></td>
                                            <td width="80"><?php echo $line['dados']['conta']; ?></td>
                                            <td width="60"><?php echo $line['dados']['carteira']; ?></td>
                                            <td width="60"><?php echo $line['dados']['convenio']; ?></td>
                                            <td width="60" style="border-right: none"><? echo $line['dados']['operacao']; ?></td>
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
                                            <th width="60"><?php echo $line['dados']['banco']; ?></th>
                                            <th width="300" style="text-align: left"><?php echo $line['dados']['nome_banco']; ?></th>
                                            <th width="80"><?php echo $line['dados']['agencia']; ?></th>
                                            <th width="80"><?php echo $line['dados']['conta']; ?></th>
                                            <th width="60"><?php echo $line['dados']['carteira']; ?></th>
                                            <th width="60"><?php echo $line['dados']['convenio']; ?></th>
                                            <th width="60" style="border-right: none"><? echo $line['dados']['operacao']; ?></th>
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
