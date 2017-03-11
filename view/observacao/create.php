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
                $("#listDisciplinaButton").click(function(){
                    $("#listDisciplinaForm").submit();
                });
                $('#cpf').autocomplete(
                {
                    source: "<? echo application; ?>pessoa/searchPessoa/?type=cpf",
                    minLength: 2,
                    select: function( event, ui ) {
                        $("#cpf").val( ui.item.cpf );
                        $("#nome").val( ui.item.nome );
                        $("#pessoa").val( ui.item.value );
                        $("#divSubmit").show();
                        return false;
                    }
                });
                $('#nome').autocomplete(
                {
                    source: "<? echo application; ?>pessoa/searchPessoa/?type=nome",
                    minLength: 2,
                    select: function( event, ui ) {
                        $("#cpf").val( ui.item.cpf );
                        $("#nome").val( ui.item.nome );
                        $("#pessoa").val( ui.item.value );
                        $("#divSubmit").show();
                        return false;
                    }
                });
                $("#buttonSubmit").click(function(){
                    $("#form").submit();
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
                    <h1>Criar Observação</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>list">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                            <a href="<?= $uri ?>search">
                                <img src="<?= image ?>icons/zoom.png" />
                                <span>Pesquisar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>SAVE" method="POST">
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
                                <div class="grid-12-12">
                                    <label>Descrição<em class="formee-req">*</em></label>
                                    <input id="descricao" name="descricao" class="validate[required] text-input" type="text" value="" />
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Origem<em class="formee-req">*</em></label>
                                        <select id="origem" name="origem">
                                            <? $classFunction['funcoesHTML']->createOptions($classFunction['origem']->loadOpcoes()) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-2-12" style="margin-left: -4px">
                                        <label>Status<em class="formee-req">*</em></label>
                                        <select id="status" name="status">
                                            <option value="1">Ativo</option>
                                            <option value="0">Inativo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-4-12">
                                    <input id="pessoa" type="hidden" name="type" value="1" />
                                    <input id="pessoa" type="hidden" name="pessoa" value="" />
                                    <input id="buttonSubmit" class="left" type="button" title="Salvar a <?php echo $action; ?>" value="Salvar" />
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
