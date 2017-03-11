<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>validationEngine/css/jquery.validationEngine.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>jquery-ui-1.9.2.custom/css/start/jquery-ui-1.9.2.custom.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "create.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine-pt.js"></script>
        <script type="text/javascript" src="<?= plugin ?>jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                $("#cpf").mask("999.999.999-99");
                $("#cpfResponsavel").mask("999.999.999-99");
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
                $('#cpfResponsavel').autocomplete(
                {
                    source: "<? echo application; ?>pessoa/searchPessoa/?type=cpf",
                    minLength: 2,
                    select: function( event, ui ) {
                        $("#cpfResponsavel").val( ui.item.cpf );
                        $("#nomeResponsavel").val( ui.item.nome );
                        $("#responsavel").val( ui.item.value );
                        return false;
                    }
                });
                $('#nomeResponsavel').autocomplete(
                {
                    source: "<? echo application; ?>pessoa/searchPessoa/?type=nome",
                    minLength: 2,
                    select: function( event, ui ) {
                        $("#cpfResponsavel").val( ui.item.cpf );
                        $("#nomeResponsavel").val( ui.item.nome );
                        $("#responsavel").val( ui.item.value );
                        return false;
                    }
                });
                $("#alunoToResponsavel").click(function(){
                    $("#cpfResponsavel").val($("#cpf").val());
                    $("#nomeResponsavel").val($("#nome").val());
                    $("#responsavel").val($("#pessoa").val());
                });
                $("#buttonSubmit").click(function(){
                    $("#form").submit();
                });
                jQuery("#form").validationEngine();
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
                    <h1>Criar Aluno</h1>
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
                                    <input id="cpf" name="cpf" type="text" value="" maxlength="14" />
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
                                    <div class="grid-6-12" style="margin-left: -4px">
                                        <label>Forma de Ingresso<em class="formee-req">*</em></label>
                                        <select id="formaIngresso" name="formaIngresso">
                                            <? $classFunction['funcoesHTML']->createOptions($classFunction['formaIngresso']->loadOpcoes()) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-12-12" style="margin-left: -4px">
                                        <label>Estrutura Curricular<em class="formee-req">*</em></label>
                                        <select id="grade" name="grade">
                                            <? $classFunction['funcoesHTML']->createOptions($data['grades']) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-3-12" style="margin-left: -4px">
                                        <label>CPF Responsável<em class="formee-req">*</em></label>
                                        <input id="cpfResponsavel" name="cpfResponsavel" class="validate[required] text-input" type="text" value="" maxlength="14" />
                                    </div>
                                    <div class="grid-8-12" style="margin-left: 8px">
                                        <label>Nome Responsável<em class="formee-req">*</em></label>
                                        <input id="nomeResponsavel" name="nomeResponsavel" class="validate[required] text-input" type="text" value="" />
                                    </div>
                                    <div class="grid-12-12" style="text-align: left">
                                        <a id="alunoToResponsavel" style="cursor: pointer; color: #0000FF" title="O próprio aluno como responsável">O próprio Aluno</a>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Período de Ingresso<em class="formee-req">*</em></label>
                                        <select id="periodoIngresso" name="periodoIngresso">
                                            <? $classFunction['funcoesHTML']->createOptions($data['parametros']); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Turno<em class="formee-req">*</em></label>
                                        <select id="turno" name="turno">
                                            <? $classFunction['funcoesHTML']->createOptions($classFunction['turnos']->loadOpcoes()) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-6-12" style="margin-left: -4px">
                                        <label>Situação<em class="formee-req">*</em></label>
                                        <select id="situacao" name="situacao">
                                            <option value="ME">Matriculado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-2-12" style="margin-left: -4px">
                                        <label>Status<em class="formee-req">*</em></label>
                                        <select id="status" name="status">
                                            <option value="1">Ativo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-8-12" style="margin-left: -4px">
                                        <label>Observa&ccedil;&atilde;o</label>
                                        <textarea id="observacao" name="observacao" id="" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="grid-4-12">
                                    <input id="responsavel" type="hidden" name="responsavel" value="" />
                                    <input id="pessoa" type="hidden" name="pessoa" value="" />
                                    <input id="buttonSubmit" class="left" type="button" title="Salvar o Aluno" value="Salvar" />
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
