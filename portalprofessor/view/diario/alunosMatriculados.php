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
                    <h1>Listar Alunos Matriculados</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= application ?>diario/show/<? echo $data['turmaDisciplina']['dados']['id']; ?>">
                                <img src="<?= image ?>icons/control_rewind_blue.png" />
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
                                    <td width="100">FOTO</td>
                                    <td width="80">R.A.</td>
                                    <td width="350" style="text-align: left">Nome:</td>
                                    <td width="80">R. FINAL</td>
                                    <td width="80">Situação</td>
                                    <td width="40" style="border-right: none">Status</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $linha = 0;
                                foreach ($data['matriculaTurmaDisciplina'] as $line) {
                                    if ($linha == 0) {
                                        $linha = 1;
                                        ?>
                                        <tr>
                                            <td width="80">
                                                <img alt="" src="<?= profile . "?id=" . base64_encode($line['dados']['cpf']) ?>" width="50" height="60" />
                                            </td>
                                            <td width="80"><?php echo $line['dados']['matricula']; ?></td>
                                            <td width="350" style="text-align: left"><?php echo $line['dados']['pessoa']; ?></td>
                                            <td width="80"><?php echo $line['dados']['resultado_final'].$line['dados']['conceito']; ?></td>
                                            <td width="80"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['situacao'], $classFunction['situacaoDisciplina']->loadOpcoes()); ?></td>
                                            <td width="40" style="border-right: none"><? echo $classFunction['enum']->enumStatus($line['dados']['status']); ?></td>
                                        </tr>

                                        <?php
                                    } else {

                                        $linha = 0;
                                        ?>
                                        <tr>
                                            <th width="80">
                                                <img alt="" src="<?= profile . "?id=" . base64_encode($line['dados']['cpf']) ?>" width="50" height="60" />
                                            </th>
                                            <th width="80"><?php echo $line['dados']['matricula']; ?></th>
                                            <th width="350" style="text-align: left"><?php echo $line['dados']['pessoa']; ?></th>
                                            <th width="80"><?php echo $line['dados']['resultado_final'].$line['dados']['conceito']; ?></th>
                                            <th width="80"><?php echo $classFunction['enum']->enumOpcoes($line['dados']['situacao'], $classFunction['situacaoDisciplina']->loadOpcoes()); ?></th>
                                            <th width="40" style="border-right: none"><? echo $classFunction['enum']->enumStatus($line['dados']['status']); ?></th>
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
