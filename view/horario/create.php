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
                $("#inicio").mask("99:99");
                $("#termino").mask("99:99");
                $('#cpf').autocomplete(
                {
                    source: "<? echo application; ?>professor/searchProfessor/?type=cpf",
                    minLength: 2,
                    select: function( event, ui ) {
                        $("#cpf").val( ui.item.cpf );
                        $("#nome").val( ui.item.nome );
                        $("#professor").val( ui.item.value );
                        $("#divSubmit").show();
                        return false;
                    }
                });
                $('#nome').autocomplete(
                {
                    source: "<? echo application; ?>professor/searchProfessor/?type=nome",
                    minLength: 2,
                    select: function( event, ui ) {
                        $("#cpf").val( ui.item.cpf );
                        $("#nome").val( ui.item.nome );
                        $("#professor").val( ui.item.value );
                        $("#divSubmit").show();
                        return false;
                    }
                });
                jQuery("#form").validationEngine();
                $("#listHorarioButton").click(function(){
                    $("#listHorarioForm").submit();
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
                    <h1>Criar Horário</h1>
                    <div class="submenus">
                        <p>
                            <a id="listHorarioButton" href="#">
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
                            <div class="grid-3-12">
                                <div class="grid-12-12" style="margin-left: -4px">
                                    <label>CPF do Professor</label>
                                    <input id="cpf" name="cpf" type="text" value="" maxlength="7" />
                                </div>
                            </div>
                            <div class="grid-8-12">
                                <div class="grid-12-12" style="margin: -2px 0 0 4px">
                                    <label>Nome do Professor</label>
                                    <input id="nome" name="nome" type="text" value="" />
                                </div>
                            </div>
                            <div id="divSubmit" style="display: none">
                                <div class="grid-12-12">
                                    <div class="grid-6-12" style="margin-left: -4px">
                                        <label>Sala<em class="formee-req">*</em></label>
                                        <select id="sala" name="sala">
                                            <? $classFunction['funcoesHTML']->createOptions($data['salas']); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Turno<em class="formee-req">*</em></label>
                                        <select id="turno" name="turno">
                                            <? $classFunction['funcoesHTML']->createOptions($classFunction['turno']); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-2-12" style="margin-left: -4px">
                                        <label>Hora Inicial:<em class="formee-req">*</em></label>
                                        <input id="inicio" name="inicio" type="text" class="validate[required] text-input" value="" maxlength="5" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-2-12" style="margin-left: -4px">
                                        <label>Hora Final:<em class="formee-req">*</em></label>
                                        <input id="termino" name="termino" type="text" class="validate[required] text-input" value="" maxlength="5" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-2-12" style="margin-left: -4px">
                                        <label>Aulas<em class="formee-req">*</em></label>
                                        <select id="aulas" name="aulas">
                                            <? $classFunction['funcoesHTML']->createOptionsValidate("1", $classFunction['aulas']->loadOpcoes()) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Dia da Semana<em class="formee-req">*</em></label>
                                        <select id="dia" name="dia">
                                            <? $classFunction['funcoesHTML']->createOptionsValidate("02", $classFunction['diaSemana']->loadOpcoes()) ?>
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
                                    <input type="hidden" name="by" value="<? echo $data['by']; ?>" />
                                    <input id="professor" type="hidden" name="professor" value="" />
                                    <input type="hidden" name="td" value="<? echo $data['turmaDisciplina']['id']; ?>" />
                                    <input class="left" type="submit" title="Salvar a <?php echo $action; ?>" value="Salvar" />
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
        <form id="listHorarioForm" action="<?= $uri ?>listByTd" method="POST">
            <input type="hidden" name="td" value="<? echo $data['turmaDisciplina']['id']; ?>" />
        </form>
    </body>
</html>
