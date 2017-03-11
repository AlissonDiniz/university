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
                    <h1>Listar Arquivos de Retorno</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri; ?>loadRetorno">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Processar Arquivo</span>
                            </a>
                            <a href="<?= $uri; ?>searchRetorno">
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
                                    <td width="310" colspan="2" style="text-align: left; padding-left: 40px">Nome:</td>
                                    <td width="60">Type</td>
                                    <td width="300">Descrição</td>
                                    <td width="120" style="font-size: 8px">Data Processamento</td>
                                    <td width="100" style="border-right: none">Usuário Operador</td>
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
                                                <a href="<?= $uri ?>reportRetorno/<?php echo $line['dados']['id']; ?>" target="_blank">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </td>
                                            <td width="250" style="text-align: left; font-size: 8px"><?php echo $line['dados']['nome']; ?></td>
                                            <td width="60"><?php echo $line['dados']['type']; ?></td>
                                            <td width="280" style="text-align: left"><?php echo $line['dados']['descricao']; ?></td>
                                            <td width="20"><?php echo $classFunction['data']->dataUSAToDataHoraBrasil($line['dados']['data']); ?></td>
                                            <td width="160" style="border-right: none"><? echo $line['dados']['usuario']; ?></td>
                                        </tr>
                                        <?php
                                    } else {
                                        $linha = 0;
                                        ?>
                                        <tr>
                                            <th width="20">
                                                <a href="<?= $uri ?>reportRetorno/<?php echo $line['dados']['id']; ?>" target="_blank">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </th>
                                            <th width="250" style="text-align: left; font-size: 8px"><?php echo $line['dados']['nome']; ?></th>
                                            <th width="60"><?php echo $line['dados']['type']; ?></th>
                                            <th width="280" style="text-align: left"><?php echo $line['dados']['descricao']; ?></th>
                                            <th width="20"><?php echo $classFunction['data']->dataUSAToDataHoraBrasil($line['dados']['data']); ?></th>
                                            <th width="160" style="border-right: none"><? echo $line['dados']['usuario']; ?></th>
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
