<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>jquery-ui-1.9.2.custom/css/start/jquery-ui-1.9.2.custom.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "search.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskMoney.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $("#dataPagamentoInit").mask("99/99/9999");
                $("#dataPagamentoEnd").mask("99/99/9999");
                $("#grade").change(function() {
                    if ($(this).val() === "%") {
                        $("#divTurmas").hide();
                    } else {
                        loadTurmas($(this).val(), $("#periodo").val());
                    }
                });
                $("#periodo").change(function() {
                    loadTurmas($("#grade").val(), $(this).val());
                });
            });
            function loadTurmas(idGrade, idPeriodo) {
                $.ajax
                        ({
                            type: "POST",
                            url: "<? echo application ?>academico/getTurmas/",
                            data: "grade=" + idGrade + "&p=" + idPeriodo,
                            cache: false,
                            success: function(data)
                            {
                                data = '<option value="%">Todas</option>' + data;
                                $("#turma").html(data);
                                $("#divTurmas").show();
                            }
                        });
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
                    <h1>Relatório de Baixas por Turma</h1>
                    <div class="submenus">
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee" style="margin-top: -20px">
                        <form id="form" target="_blank" action="<?= $uri ?>resultReportByTurma" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-12-12" style="margin-left: -4px">
                                    <label>Estrutura Curricular<em class="formee-req">*</em></label>
                                    <select id="grade" name="grade">
                                        <option value="%">Todas</option>
                                        <? $classFunction['funcoesHTML']->createOptions($data['grades']) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Período<em class="formee-req">*</em></label>
                                    <select id="periodo" name="periodo">
                                        <option value="%">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptionsValidate($data['parametros']['periodo_matricula_id'], $data['periodos']); ?>
                                    </select>
                                </div>
                            </div>
                            <div id="divTurmas" class="grid-12-12" style="display: none">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Turmas</label>
                                    <select id="turma" name="turma">
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div style="width: 260px; float: left; margin-right: 20px">
                                    <div class="grid-10-12" style="margin-left: -4px">
                                        <label>Data de Pagamento Inicial</label>
                                        <input id="dataPagamentoInit" name="dataPagamentoInit" type="text" value="<? echo "01" . date("/m/Y"); ?>" maxlength="10" />
                                    </div>
                                </div>
                                <div style="width: 260px; float: left">
                                    <div class="grid-10-12" style="margin-left: -4px">
                                        <label>Data de Pagamento Final</label>
                                        <input id="dataPagamentoEnd" name="dataPagamentoEnd" type="text" value="<? echo date("d/m/Y"); ?>" maxlength="10" />
                                    </div>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Forma de Pagamento</label>
                                    <select id="formaPagamento" name="formaPagamento">
                                        <option value="%">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptions($data['formasPagamento']); ?>
                                    </select>
                                </div>
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
