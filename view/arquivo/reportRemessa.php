<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>validationEngine/css/jquery.validationEngine.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "list.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine-pt.js"></script>
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
                    <h1>Visualizar dados do Arquivo de Remessa</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>listRemessa">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                            <a href="<?= $uri ?>searchRemessa">
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
                                    <td width="120"style="text-align: center">Nosso Numero:</td>
                                    <td width="400">Nome</td>
                                    <td width="100">Valor</td>
                                    <td width="120" style="border-right: none">Data Vencimento</td>
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
                                            <td width="120" style="text-align: center"><?php echo $line['nossoNumero']; ?></td>
                                            <td width="400" style="text-align: left"><?php echo $line['aluno']; ?></td>
                                            <td width="100">R$ <?php echo $line['valor']; ?></td>
                                            <td width="120" style="border-right: none"><? echo $line['dataVencimento']; ?></td>
                                        </tr>
                                        <?php
                                    } else {
                                        $linha = 0;
                                        ?>
                                        <tr>
                                            <th width="120" style="text-align: center"><?php echo $line['nossoNumero']; ?></th>
                                            <th width="400" style="text-align: left"><?php echo $line['aluno']; ?></th>
                                            <th width="100">R$ <?php echo $line['valor']; ?></th>
                                            <th width="120" style="border-right: none"><? echo $line['dataVencimento']; ?></th>
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
