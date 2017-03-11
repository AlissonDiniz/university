<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
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
                    <h1>Listar Módulos</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= application ?>grade/show/<? echo $data['grade']['id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                            <a href="<?= $uri ?>create/?grade=<? echo $data['grade']['id']; ?>">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Cadastrar</span>
                            </a>
                        </p>
                    </div>
                    <?
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-bottom: 15px">
                        <label style="width: 100px">
                            <span class="legenda">C&oacute;digo:</span>
                            <br />
                            <span class="texto"><? echo $data['grade']['codigo']; ?></span>
                        </label>
                        <label style="width: 500px">
                            <span class="legenda">Nome Curso:</span>
                            <br />
                            <span class="texto"><? echo $data['grade']['nome']; ?></span>
                        </label>
                    </div>
                    <div>
                        <table id="mytable" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <td width="140" colspan="2">Grade</td>
                                    <td width="80">C&oacute;digo</td>
                                    <td width="400" style="text-align: left; padding-left: 40px">Descrição:</td>
                                    <td width="80" style="border-right: none">Carga H</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $linha = 0;
                                foreach ($data['modulo'] as $line) {
                                    if ($linha == 0) {
                                        $linha = 1;
                                        ?>
                                        <tr>
                                            <td width="20">
                                                <a href="<?= $uri ?>show/<?php echo $line['dados']['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </td>
                                            <td width="120"><?php echo $data['grade']['codigo']; ?></td>
                                            <td width="80"><?php echo $line['dados']['codigo']; ?></td>
                                            <td width="400" style="text-align: left"><?php echo $line['dados']['descricao']; ?></td>
                                            <td width="80" style="border-right: none"><?php echo $line['dados']['carga_horaria']; ?></td>
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
                                            <th width="120"><?php echo $data['grade']['codigo']; ?></th>
                                            <th width="80"><?php echo $line['dados']['codigo']; ?></th>
                                            <th width="400" style="text-align: left"><?php echo $line['dados']['descricao']; ?></th>
                                            <th width="80" style="border-right: none"><?php echo $line['dados']['carga_horaria']; ?></th>
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
