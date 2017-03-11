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
        <script type="text/javascript">
            $(document).ready(function() {
                $("#createButton").click(function() {
                    $("#createForm").submit();
                });
            });
        </script>
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
                    <h1>Listar Equivalências de Disciplinas</h1>
                    <div class="submenus">
                        <p>
                            <a id="createButton" href="#">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Lançar Equivalência</span>
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
                            <span class="texto"><? echo $data['aluno']['dados']['matricula']; ?></span>
                        </label>
                        <label  style="width: 500px">
                            <span class="legenda">Nome:</span>
                            <br />
                            <span class="texto"><? echo $data['aluno']['dados']['nome']; ?></span>
                        </label>
                    </div>
                    <div>
                        <table id="mytable" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <td width="100" colspan="2">Per&iacute;odo</td>
                                    <td width="220">Disciplina Origem:</td>
                                    <td width="220">Disciplina Equivalente:</td>
                                    <td width="100">Situação</td>
                                    <td width="60" style="border-right: none">Status</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $linha = 0;
                                foreach ($data['equivalenciaDisciplina'] as $line) {
                                    if ($linha == 0) {
                                        $linha = 1;
                                        ?>
                                        <tr>
                                            <td width="20">
                                                <a href="<?= $uri ?>show/<?php echo $line['dados']['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </td>
                                            <td width="80"><?php echo $line['dados']['periodo']; ?></td>
                                            <td width="220"><?php echo $line['dados']['codigoDisciplina'] . " - " . $line['dados']['disciplina']; ?></td>
                                            <td width="220"><?php echo $line['dados']['codigoDisciplinaEQ'] . " - " . $line['dados']['disciplinaEQ']; ?></td>
                                            <td width="100"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['situacao'], $classFunction['situacaoDisciplina']->loadOpcoes()); ?></td>
                                            <td width="60" style="border-right: none"><?php echo $classFunction['enum']->enumStatus($line['dados']['status']); ?></td>
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
                                            <th width="120"><?php echo $line['dados']['periodo']; ?></th>
                                            <th width="400" style="text-align: left"><?php echo $line['dados']['codDisciplina'] . " - " . $line['dados']['disciplina']; ?></th>
                                            <th width="100"><?php echo $line['dados']['resultado_final']; ?></th>
                                            <th width="100"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['situacao'], $classFunction['situacaoDisciplina']->loadOpcoes()); ?></th>
                                            <th width="60" style="border-right: none"><?php echo $classFunction['enum']->enumStatus($line['dados']['status']); ?></th>
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
        <form id="createForm" action="<? echo $uri ?>create" method="POST">
            <input type="hidden" name="aluno" value="<? echo $data['aluno']['dados']['id']; ?>" />
        </form>
    </body>
</html>
