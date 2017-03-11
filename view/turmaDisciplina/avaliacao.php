<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
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
                    <h1>Listar Avaliações da Turma Disciplina</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= application ?>turmaDisciplina/showD/<? echo $data['turmaDisciplina']['dados']['id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                        </p>
                    </div>
                    <?
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-top: 0; margin-bottom: 10px">
                        <label style="width: 500px">
                            <span class="legenda">Disciplina:</span>
                            <br />
                            <span class="texto"><? echo $data['turmaDisciplina']['dados']['codDisciplina'] . " - " . $data['turmaDisciplina']['dados']['disciplina']; ?></span>
                        </label>
                        <label style="width: 100px">
                            <span class="legenda">Per&iacute;odo:</span>
                            <br />
                            <span class="texto"><? echo $data['turmaDisciplina']['dados']['periodo']; ?></span>
                        </label>
                    </div>
                    <div>
                        <table id="mytable" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <td width="760" colspan="2" style="border-right: none">Nome da Etapa</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $linha = 0;
                                foreach ($data['etapas'] as $line) {
                                    if ($linha == 0) {
                                        $linha = 1;
                                        ?>
                                        <tr>
                                            <td width="40">
                                                <a href="<?= $uri ?>showAvaliacao/<?php echo $line['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </td>
                                            <td width="760" style="border-right: none; text-align: center"><?php echo $line['nome']; ?></td>
                                        </tr>

                                        <?php
                                    } else {

                                        $linha = 0;
                                        ?>
                                        <tr>
                                            <th width="40">
                                                <a href="<?= $uri ?>showAvaliacao/<?php echo $line['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </th>
                                            <th width="760" style="border-right: none; text-align: center"><?php echo $line['nome']; ?></th>
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
