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
                    <h1>Listar Disciplinas do Módulo</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= application ?>modulo/show/<? echo $data['modulo']['id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                            <a href="<?= $uri ?>create/?modulo=<? echo $data['modulo']['id']; ?>">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Cadastrar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-bottom: 20px">
                        <label style="width: 100px">
                            <span class="legenda">C&oacute;d Estrutura:</span>
                            <br />
                            <span class="texto"><? echo $data['modulo']['codGrade']; ?></span>
                        </label>
                        <label style="width: 50px">
                            <span class="legenda">C&oacute;digo:</span>
                            <br />
                            <span class="texto"><? echo $data['modulo']['codigo']; ?></span>
                        </label>
                        <label style="width: 100px">
                            <span class="legenda">Carga Horária:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['number']->formatNumber($data['modulo']['carga_horaria']); ?></span>
                        </label>
                        <label style="width: 420px">
                            <span class="legenda">Descrição:</span>
                            <br />
                            <span class="texto"><? echo $data['modulo']['descricao']; ?></span>
                        </label>
                    </div>
                    <div>
                        <table id="mytable" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <td width="120" colspan="2">Código</td>
                                    <td width="380" style="text-align: left; padding-left: 40px">Nome:</td>
                                    <td width="80">Carga H</td>
                                    <td width="100" style="border-right: none">Obrigatoria</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $linha = 0;
                                foreach ($data['moduloDisciplina'] as $line) {
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
                                            <td width="380" style="text-align: left"><?php echo $line['dados']['nome']; ?></td>
                                            <td width="100" ><?php echo $line['dados']['carga_horaria']; ?></td>
                                            <td width="100" style="border-right: none"><?php echo $classFunction['enum']->enumObrigatorio($line['dados']['obrigatorio']); ?></td>
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
                                            <th width="380" style="text-align: left"><?php echo $line['dados']['nome']; ?></th>
                                            <th width="100" ><?php echo $line['dados']['carga_horaria']; ?></th>
                                            <th width="100" style="border-right: none"><?php echo $classFunction['enum']->enumObrigatorio($line['dados']['obrigatorio']); ?></th>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <form id="editForm" action="<?= $uri ?>edit" method="POST">
                            <input type="hidden" name="id" value="<? echo $data['dados']['id']; ?>" />
                        </form>
                    </div>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
        <form id="createDisciplinaForm" action="<?= $uri ?>addDisciplina" method="POST">
            <input type="hidden" name="modulo" value="<? echo $data['dados']['id']; ?>" />
        </form>
    </body>
</html>
