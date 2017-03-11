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
                $('#codDisciplina').autocomplete(
                {
                    source: "<? echo $uri; ?>getTurmaDisciplina/?type=cod&m=<? echo $data['matricula']['id']; ?>",
                    minLength: 2,
                    select: function( event, ui ) {
                        $("#codDisciplina").val( ui.item.cod );
                        $("#nomeDisciplina").val( ui.item.nome );
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
                        $("#turmaDisciplinaManual").val( ui.item.value );
                        $("#divManualSubmit").show();
                        return false;
                    }
                });
            });
            function tecla(objeto, event) {
                var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
                if((keyCode > 47 && keyCode < 58) && check(objeto.value)){
                    return true;
                }else{
                    if(keyCode == 46 || keyCode == 8 || keyCode == 0 || keyCode == 37 || keyCode == 39){
                        return true;
                    }else{
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
                    <h1>Dispensar Disciplinas no Aluno</h1>
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
                        <form id="formManual" action="<?= $uri ?>SAVED" method="POST">
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
                                <div class="grid-12-12">
                                    <label>Carga Horária Dispensada:</label>
                                    <div class="grid-3-12" style="margin-left: -4px">
                                        <input id="cargaHorariaDispensada" name="cargaHorariaDispensada" type="text" value="" maxlength="4" onkeypress="return tecla(this, event)" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-3-12" style="margin-left: -4px">
                                        <label>Resultado Final:</label>
                                        <input id="resultadoFinal" name="resultadoFinal" type="text" value="" maxlength="4" onkeypress="return tecla(this, event)" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-3-12" style="margin-left: -4px">
                                        <label>Conceito:</label>
                                        <input id="conceito" name="conceito" type="text" value="" maxlength="10"  />
                                    </div>
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
