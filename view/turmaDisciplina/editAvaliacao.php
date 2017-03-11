<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "edit.css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "list.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            function tecla(objeto, event) {
                var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
                if ((keyCode > 47 && keyCode < 58) && check(objeto.value)) {
                    return true;
                } else {
                    if (keyCode == 46 || keyCode == 8 || keyCode == 0 || keyCode == 37 || keyCode == 39) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
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
                    <h1>Mostrar Avaliação</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= application ?>turmaDisciplina/showAvaliacao/<? echo $data['turmaDisciplina']['dados']['id'] . "-" . $data['etapa']['id']; ?>">
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
                    <div class="formulario formee" style="margin: 0">
                        <form action="<?= $uri ?>UPDATEAVALIACAO" method="POST">
                            <table id="mytable" cellspacing="0" cellpadding="5">
                                <thead>
                                    <tr>
                                        <td width="80">R.A.</td>
                                        <td width="450" style="text-align: left">Nome:</td>
                                        <td width="120">Nome Etapa</td>
                                        <td width="80" style="border-right: none">Nota</td>
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
                                                <td width="80"><?php echo $line['dados']['matricula']; ?></td>
                                                <td width="450" style="text-align: left"><?php echo $line['dados']['pessoa']; ?></td>
                                                <td width="120"><?php echo $data['etapa']['nome']; ?></td>
                                                <td width="80" style="border-right: none">
                                                    <div class="grid-12-12">
                                                        <input style="text-align: center" id="nota<? echo $line['dados']['id']."-".$data['etapa']['id']."-".$line['dados']['idNota']; ?>" name="nota[<? echo $line['dados']['id']."-".$data['etapa']['id']."-".$line['dados']['idNota']; ?>]" type="text" value="<? echo $classFunction['number']->formatNota($line['dados']['valorNota']); ?>" maxlength="4" onkeypress="return tecla(this, event)" />
                                                    </div>
                                                </td>
                                            </tr>

                                            <?php
                                        } else {

                                            $linha = 0;
                                            ?>
                                            <tr>
                                                <th width="80"><?php echo $line['dados']['matricula']; ?></th>
                                                <th width="450" style="text-align: left"><?php echo $line['dados']['pessoa']; ?></th>
                                                <th width="120"><?php echo $data['etapa']['nome']; ?></th>
                                                <th width="80" style="border-right: none"><strong><? echo $classFunction['number']->formatNota($line['dados']['nota']); ?></strong></th>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="grid-4-12" style="margin-left: 20px">
                                <input id="editButton" class="left" type="submit" title="Salvar a Avaliação" value="Salvar" />
                            </div>
                            <input type="hidden" name="id" value="<? echo $data['turmaDisciplina']['dados']['id'] . "-" . $data['etapa']['id']; ?>" />
                        </form>
                    </div>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
    </body>
</html>
