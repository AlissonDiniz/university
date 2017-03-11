<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "list.css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
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
                    <h1>Listar Acréscimos do Título</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= application ?>titulo/show/<? echo $data['titulo']['id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                            <a href="<?= $uri ?>createByTitulo/<? echo $data['titulo']['id']; ?>">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Cadastrar</span>
                            </a>
                        </p>
                    </div>
                    <?
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-bottom: 10px">
                        <label style="width: 110px">
                            <span class="legenda">R.A.:</span>
                            <br />
                            <span class="texto"><? echo $data['titulo']['matricula']; ?></span>
                        </label>
                        <label  style="width: 400px">
                            <span class="legenda">Nome:</span>
                            <br />
                            <span class="texto"><? echo $data['titulo']['nome']; ?></span>
                        </label>
                    </div>
                    <div>
                       <table id="mytable" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <td width="160" colspan="2">Nosso Número</td>
                                    <td width="100">Valor</td>
                                    <td width="30">Parc</td>
                                    <td width="350">Observação</td>
                                    <td width="100" style="border-right: none; font-size: 0.6em">Status</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $linha = 0;
                                foreach ($data['acrescimos'] as $line) {
                                    if ($linha == 0) {
                                        $linha = 1;
                                        ?>
                                        <tr>
                                            <td width="20">
                                                <a href="<?= $uri ?>showByTitulo/<?php echo $line['dados']['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </td>
                                            <td width="140"><?php echo $line['dados']['nosso_numero']; ?></td>
                                            <td width="120"><?php echo $classFunction["number"]->formatMoney($line['dados']['valor']); ?></td>
                                            <td width="30"><?php echo $line['dados']['parcela']; ?></td>
                                            <td width="320"><?php echo $line['dados']['observacao']; ?></td>
                                            <td width="100" style="border-right: none"><?php echo $classFunction["enum"]->enumStatus($line['dados']['status']); ?></td>
                                        </tr>

                                        <?php
                                    } else {

                                        $linha = 0;
                                        ?>
                                        <tr>
                                            <th width="20">
                                                <a href="<?= $uri ?>showByTitulo/<?php echo $line['dados']['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </th>
                                            <th width="140"><?php echo $line['dados']['nosso_numero']; ?></th>
                                            <th width="120"><?php echo $classFunction["number"]->formatMoney($line['dados']['valor']); ?></th>
                                            <th width="30"><?php echo $line['dados']['parcela']; ?></th>
                                            <th width="320"><?php echo $line['dados']['observacao']; ?></th>
                                            <th width="100" style="border-right: none"><?php echo $classFunction["enum"]->enumStatus($line['dados']['status']); ?></th>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <form id="formRegenarate" action="<?= $uri ?>regenerate" method="POST">
                        <input type="hidden" name="matricula" value="<? echo $data['matricula']['id']; ?>" />
                    </form>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
    </body>
</html>
