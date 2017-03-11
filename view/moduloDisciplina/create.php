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
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#listDisciplinaButton").click(function(){
                    $("#listDisciplinaForm").submit();
                });
                $('#codigo').autocomplete(
                {
                    source: "<? echo $uri; ?>search/?type=cod",
                    minLength: 2,
                    select: function( event, ui ) {
                        $("#codigo").val( ui.item.codigo );
                        $("#nome").val( ui.item.nome );
                        $("#disciplina").val( ui.item.value );
                        $("#divSubmit").show();
                        return false;
                    }
                });
                $('#nome').autocomplete(
                {
                    source: "<? echo $uri; ?>search/?type=nome",
                    minLength: 2,
                    select: function( event, ui ) {
                        $("#codigo").val( ui.item.codigo );
                        $("#nome").val( ui.item.nome );
                        $("#disciplina").val( ui.item.value );
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
                    <h1>Adicionar Disciplina no Módulo</h1>
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
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>SAVE" method="POST">
                            <div class="grid-3-12">
                                <div class="grid-12-12" style="margin-left: -4px">
                                    <label>Código</label>
                                    <input id="codigo" name="codigo" type="text" value="" maxlength="7" />
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
                                    <div class="grid-3-12" style="margin-left: -4px">
                                        <label>Obrigatório<em class="formee-req">*</em></label>
                                        <select id="obrigatorio" name="obrigatorio">
                                            <option value="1">Obrigatória</option>
                                            <option value="0">Optativa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-4-12">
                                    <input id="disciplina" type="hidden" name="disciplina" value="" />
                                    <input type="hidden" name="modulo" value="<? echo $data['dados']['id']; ?>" />
                                    <input id="buttonSubmit" class="left" type="button" title="Salvar a Disciplina no Modulo" value="Salvar" />
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
        <form id="listDisciplinaForm" action="<?= $uri ?>list" method="POST">
            <input type="hidden" name="modulo" value="<? echo $data['dados']['id']; ?>" />
        </form>
    </body>
</html>
