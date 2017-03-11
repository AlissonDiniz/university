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
        <link rel="stylesheet" type="text/css" href="<?= css . "list.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskMoney.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine-pt.js"></script>
        <script type="text/javascript" src="<?= plugin ?>jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            var opcaoPagamento = 1;
            jQuery(document).ready(function() {
                $('#nome').autocomplete(
                    {
                        source: "<? echo application; ?>aluno/searchAluno/?type=nome",
                        minLength: 2,
                        select: function(event, ui) {
                            $("#nome").val(ui.item.nome);
                            $("#idAluno").val(ui.item.value);
                            $("#matricula").val(ui.item.matricula);
                            $("#divSubmitForm").show();
                            $("#divSubmit").show();
                            return false;
                        }
                    });
                $('#nossoNumero').keyup(function(e) {
                    if ($(this).val().length > 10) {
                        $("#divSubmit").show();
                        $("#divSubmitForm").hide();
                    } else {
                        $("#divSubmitForm").hide();
                        $("#divSubmit").hide();
                    }
                });
                $('#nossoNumero').keypress(function(e) {
                    return verificaNumero(e);
                });
            });

            function submitForm() {
                $('#form').submit();
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
                    <h1>Criar Boleto Bancário</h1>
                    <div class="submenus">
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee" style="margin-top: -10px">
                        <form id="form" action="<?= $uri ?>report" target="_blank" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Nosso Número</label>
                                    <input id="nossoNumero" name="nossoNumero" type="text" value="" maxlength="15" />
                                </div>
                            </div>
                            <div class="grid-3-12">
                                <div class="grid-12-12" style="margin-left: -2px">
                                    <label>Matricula</label>
                                    <input id="matricula" name="matricula" type="text" value="" maxlength="15" disabled="disabled" />
                                </div>
                            </div>                            
                            <div class="grid-8-12">
                                <div class="grid-12-12" style="margin: -2px 0 0 4px">
                                    <label>Nome do Aluno</label>
                                    <input id="nome" name="nome" type="text" value="" />
                                </div>
                            </div>
                            <div id="divSubmitForm" style="display: none">
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Período<em class="formee-req">*</em></label>
                                        <select id="periodo" name="periodo">
                                            <? $classFunction['funcoesHTML']->createOptionsValidate($data['parametros']['dados']['periodo_atual_id'], $data['periodos']) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-2-12" style="margin-left: -4px">
                                        <label>Parcela<em class="formee-req">*</em></label>
                                        <select id="parcela" name="parcela">
                                            <? $classFunction['funcoesHTML']->createOptions($classFunction['numbers']->loadOpcoes()) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="divSubmit" style="display: none">
                                <div class="grid-12-12">
                                    <div class="grid-5-12" style="margin-left: -4px">
                                        <label>Vencimento Hoje</label>
                                        <input id="vencimentoHoje" name="vencimentoHoje" style="float: left" type="checkbox" />
                                    </div>
                                </div>
                                <div class="grid-4-12">
                                    <input id="idAluno" type="hidden" name="idAluno" value="" />
                                    <input class="left" type="button" onclick="submitForm()" title="Criar Boleto Bancário" value="Criar Boleto" />
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
