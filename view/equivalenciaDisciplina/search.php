<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>jquery-ui-1.9.2.custom/css/start/jquery-ui-1.9.2.custom.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "create.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                $("#cpf").mask("999.999.999-99");
                $('#cpf').autocomplete(
                {
                    source: "<? echo application; ?>aluno/searchAluno/?type=cpf",
                    minLength: 2,
                    select: function( event, ui ) {
                        $("#cpf").val( ui.item.cpf );
                        $("#nome").val( ui.item.nome );
                        $("#aluno").val( ui.item.value );
                        $("#divSubmit").show();
                        return false;
                    }
                });
                $('#nome').autocomplete(
                {
                    source: "<? echo application; ?>aluno/searchAluno/?type=nome",
                    minLength: 2,
                    select: function( event, ui ) {
                        $("#cpf").val( ui.item.cpf );
                        $("#nome").val( ui.item.nome );
                        $("#aluno").val( ui.item.value );
                        $("#divSubmit").show();
                        return false;
                    }
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
                    <h1>Escolher o Aluno</h1>
                    <div class="submenus">
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee" style="margin-top: -20px">
                        <form id="form" action="<?= $uri ?>list" method="POST">
                            <div class="grid-3-12">
                                <div class="grid-12-12" style="margin-left: -4px">
                                    <label>CPF</label>
                                    <input id="cpf" name="cpf" type="text" value="" maxlength="7" />
                                </div>
                            </div>
                            <div class="grid-9-12">
                                <div class="grid-12-12" style="margin: -2px 0 0 4px">
                                    <label>Nome</label>
                                    <input id="nome" name="nome" type="text" value="" />
                                </div>
                            </div>
                            <div id="divSubmit" style="display: none">
                                <div class="grid-4-12">
                                    <input id="aluno" type="hidden" name="aluno" value="" />
                                    <input class="left" type="submit" title="Buscar Notas e Faltas" value="Buscar" />
                                </div>
                            </div>
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
