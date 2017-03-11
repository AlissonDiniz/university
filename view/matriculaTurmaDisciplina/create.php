<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>jquery-ui-1.9.2.custom/css/start/jquery-ui-1.9.2.custom.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "create.css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "list.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                $("#listDisciplinaButton").click(function(){
                    $("#listDisciplinaForm").submit();
                });
                $("#formButton").click(function(){
                    if(validar()){
                        $("#form").submit();
                    }else{
                        alert("Pelo menos 1 checkbox deve ser marcado!");
                    }
                });
                $("#manualButton").click(function(){
                    $("#divManual").show();
                });
                $('#codDisciplina').autocomplete(
                {
                    source: "<? echo $uri; ?>getTurmaDisciplina/?type=cod&m=<? echo $data['matricula']['id']; ?>",
                    minLength: 2,
                    select: function( event, ui ) {
                        $("#codDisciplina").val( ui.item.cod );
                        $("#nomeDisciplina").val( ui.item.nome );
                        $("#horariosManual").html( ui.item.horario );
                        $("#vagasManual").html( ui.item.vagas );
                        $("#turmaDisciplinaManual").val( ui.item.value );
                        $("#divManualSubmit").show();
                        return false;
                    }
                });
                $('#nomeDisciplina').autocomplete(
                {
                    source: "<? echo $uri; ?>getTurmaDisciplina/?type=nome&m=<? echo $data['matricula']['id']; ?>",
                    minLength: 2,
                    select: function( event, ui ) {
                        $("#codDisciplina").val( ui.item.cod );
                        $("#nomeDisciplina").val( ui.item.nome );
                        $("#horariosManual").html( ui.item.horario );
                        $("#vagasManual").html( ui.item.vagas );
                        $("#turmaDisciplinaManual").val( ui.item.value );
                        $("#divManualSubmit").show();
                        return false;
                    }
                });
            });
            function validar(){
                var form = document.getElementsByTagName("input");
                for (var i = 0; i < form.length; i++){
                    if (form[i].type == "checkbox" && form[i].checked == true){
                        return true;
                    }
                }
                return false;
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
                    <h1>Matricular Disciplinas no Aluno</h1>
                    <div class="submenus">
                        <p>
                            <a id="listDisciplinaButton" href="#">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>SAVE" method="POST">
                            <div style="margin-left: -10px">
                                <table id="mytable" cellspacing="0" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <td width="400" colspan="2" style="text-align: left; padding-left: 40px">Disciplina</td>
                                            <td width="200" colspan="2">Horários</td>
                                            <td width="60" style="border-right: none">Vagas</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $linha = 0;
                                        foreach ($data['turmaDisciplina'] as $line) {
                                            if ($linha == 0) {
                                                $linha = 1;
                                                ?>
                                                <tr>
                                                    <td width="20">
                                                        <input type="checkbox" name="turmaDisciplina[]" value="<?php echo $line['id']; ?>" />
                                                    </td>
                                                    <td width="380" style="text-align: left"><?php echo $line['disciplina']; ?></td>
                                                    <td width="85" style="text-align: left"><?php echo $line['horario']['dia']; ?></td>
                                                    <td width="115" style="text-align: left"><?php echo $line['horario']['horario']; ?></td>
                                                    <td width="60" style="border-right: none"><?php echo $line['vagas']; ?></td>
                                                </tr>
                                                <?php
                                            } else {

                                                $linha = 0;
                                                ?>
                                                <tr>
                                                    <th width="20">
                                                        <input type="checkbox" name="turmaDisciplina[]" value="<?php echo $line['id']; ?>" />
                                                    </th>
                                                    <th width="380" style="text-align: left"><?php echo $line['disciplina']; ?></th>
                                                    <th width="85" style="text-align: left"><?php echo $line['horario']['dia']; ?></th>
                                                    <th width="115" style="text-align: left"><?php echo $line['horario']['horario']; ?></th>
                                                    <th width="60" style="border-right: none"><?php echo $line['vagas']; ?></th>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="divSubmit" class="grid-12-12">
                                <input type="hidden" name="matricula" value="<? echo $data['matricula']['id']; ?>" />
                                <input id="manualButton" class="left" type="button" title="Matricular Manual" value="Manual" />
                                <input id="formButton" class="left" type="button" title="Avançar" value="Avançar" />
                            </div>
                        </form>
                    </div>
                    <div id="divManual" class="formulario formee" style="display: none">
                        <form id="formManual" action="<?= $uri ?>SAVE" method="POST">
                            <div class="grid-3-12">
                                <div class="grid-12-12" style="margin-left: -4px">
                                    <label>Cód. Disciplina:</label>
                                    <input id="codDisciplina" name="codDisciplina" type="text" value="" maxlength="7" />
                                </div>
                            </div>
                            <div class="grid-9-12">
                                <div class="grid-12-12" style="margin: -2px 0 0 4px">
                                    <label>Nome Disciplina:</label>
                                    <input id="nomeDisciplina" name="nomeDisciplina" type="text" value="" />
                                </div>
                            </div>
                            <div id="divManualSubmit" style="display: none">
                                <div class="conteudo formee" style="margin: 0">
                                    <label>
                                        <span class="legenda">Horários:</span>
                                        <br />
                                        <span id="horariosManual" class="texto"></span>
                                    </label>
                                    <label>
                                        <span class="legenda">Vagas:</span>
                                        <br />
                                        <span id="vagasManual" class="texto"></span>
                                    </label>
                                </div>
                                <div class="grid-12-12">
                                    <input class="left" type="submit" title="Avançar" value="Avançar" />
                                </div>
                            </div>
                            <input id="turmaDisciplinaManual" type="hidden" name="turmaDisciplina[]" value="" />
                            <input type="hidden" name="matricula" value="<? echo $data['matricula']['id']; ?>" />
                        </form>
                    </div>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
        <form id="listDisciplinaForm" action="<?= $uri ?>list" method="POST">
            <input type="hidden" name="m" value="<? echo $data['matricula']['id']; ?>" />
        </form>
    </body>
</html>
