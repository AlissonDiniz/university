<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "search.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $("#dataInicial").mask("99/99/9999");
                $("#dataFinal").mask("99/99/9999");
                $("#horaFinal").mask("99:99");
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
                    <h1>Relatório - Auditoria de Operações no Sistema</h1>
                    <div class="submenus">
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee" style="margin-top: -20px">
                        <form id="form" target="_blank" action="<?= $uri ?>resultReportLogs" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-6-12" style="margin-left: -4px">
                                    <label>Forma Operação<em class="formee-req">*</em></label>
                                    <select id="formaOperacao" name="formaOperacao">
                                        <option value="rotina">Acesso ao Sistema</option>
                                        <option value="select">Selecionar dados no Sistema</option>
                                        <option value="update">Alterar dados no Sistema</option>
                                        <option value="delete">Deletar dados no Sistema</option>
                                        <option value="insert">Inserir dados no Sistema</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Meta Dado</label>
                                    <input id="metaDado" name="metaDado" type="text" value="" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-6-12" style="margin-left: -4px">
                                    <label>Usuário<em class="formee-req">*</em></label>
                                    <select id="user" name="user">
                                        <option value="%">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptions($data['users']) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <label>Data Inicial<em class="formee-req">*</em></label>
                                <input id="dataInicial" style="float: left; width: 150px" name="dataInicial" class="validate[required] text-input" type="text" value="<? echo date("d/m/Y"); ?>" maxlength="10" />
                                <input id="horaInicial" style="float: left; margin-left: 10px; width: 70px" name="horaInicial" class="validate[required] text-input" type="text" value="00:00" maxlength="5" />
                            </div>
                            <div class="grid-12-12">
                                <label>Data Final<em class="formee-req">*</em></label>
                                <input id="dataFinal" style="float: left; width: 150px" name="dataFinal" class="validate[required] text-input" type="text" value="<? echo date("d/m/Y"); ?>" maxlength="10" />
                                <input id="horaFinal" style="float: left; margin-left: 10px; width: 70px" name="horaFinal" class="validate[required] text-input" type="text" value="<? echo date("H:i"); ?>" maxlength="5" />
                            </div>
                            <div class="grid-4-12">
                                <input class="left" type="submit" title="Gerar Relatório" value="Gerar Relatório" />
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
