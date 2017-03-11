<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "list.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#editButton").click(function() {
                    $("#editForm").submit();
                });
                $("#listAulaButton").click(function() {
                    $("#listAulaForm").submit();
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
                    <h1>Mostrar Aula da Turma Disciplina</h1>
                    <div class="submenus">
                        <p>
                            <a id="listAulaButton" href="#">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee">
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
                        <label style="width: 720px">
                            <span class="legenda">Conteúdo:</span>
                            <br />
                            <span class="texto" style="text-align: justify"><? echo $data['aula']['dados']['conteudo']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Horário:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['aula']['dados']['dia'], $classFunction['diaSemana']->loadOpcoes()) . " | " . $data['aula']['dados']['inicio'] . " - " . $data['aula']['dados']['termino'] . " | " . $data['aula']['dados']['sala'] . " | A: " . $data['aula']['dados']['aulas']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Data:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['data']->dataUSAToDataBrasil($data['aula']['dados']['data_aula']); ?></span>
                        </label>
                    </div>
                    <div>
                        <table id="mytable" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <td width="80">FOTO</td>
                                    <td width="80">R.A.</td>
                                    <td width="350" style="text-align: left">Nome:</td>
                                    <td width="100">Situação</td>
                                    <td width="70" style="border-right: none">QuanT</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $contador = 0;
                                $linha = 0;
                                foreach ($data['faltas'] as $line) {
                                    if ($linha == 0) {
                                        $linha = 1;
                                        ?>
                                        <tr>
                                            <td width="80">
                                                <img alt="" src="<?= profile . "?id=" . base64_encode($line['dados']['cpf']) ?>" width="30" height="35" />
                                            </td>
                                            <td width="80"><?php echo $line['dados']['matricula']; ?></td>
                                            <td width="350" style="text-align: left"><?php echo $line['dados']['nome']; ?></td>
                                            <td width="100"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['tipo'], $classFunction['faltaEnum']->loadOpcoes()); ?></td>
                                            <td width="70" style="border-right: none"><?php echo $line['dados']['valor']; ?></td>
                                        </tr>

                                        <?php
                                    } else {

                                        $linha = 0;
                                        ?>
                                        <tr>
                                            <th width="80">
                                                <img alt="" src="<?= profile . "?id=" . base64_encode($line['dados']['cpf']) ?>" width="30" height="35" />
                                            </th>
                                            <th width="80"><?php echo $line['dados']['matricula']; ?></th>
                                            <th width="350" style="text-align: left"><?php echo $line['dados']['nome']; ?></th>
                                            <th width="100"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['tipo'], $classFunction['faltaEnum']->loadOpcoes()); ?></th>
                                            <th width="70" style="border-right: none"><?php echo $line['dados']['valor']; ?></th>
                                        </tr>
                                        <?php
                                    }
                                    $contador++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="conteudo formee">
                        <div class="grid-4-12">
                            <input id="editButton" class="left" type="button" title="Editar" value="Editar" />
                        </div>
                        <form id="editForm" action="<?= $uri ?>edit" method="POST">
                            <input type="hidden" name="id" value="<? echo $data['aula']['dados']['id']; ?>" />
                        </form>
                    </div>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
        <form id="listAulaForm" action="<?= $uri ?>list" method="POST">
            <input type="hidden" name="id" value="<? echo $data['aula']['dados']['turmaDisciplina']; ?>" />
        </form>
    </body>
</html>
