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
                $("#cpf").mask("999.999.999-99");
                $("#turma").hide();
                $("#grade").change(function() {
                    if (this.value != "0") {
                        $("#cpf").hide();
                        $("#cpf").val("");
                        $("#matricula").hide();
                        $("#matricula").val("");
                        loadTurma(this.value, $("#periodo").val());
                    } else {
                        $("#turma").hide();
                        $("#cpf").show();
                        $("#matricula").show();
                    }
                });
                $("#periodo").change(function() {
                    loadTurma($("#grade").val(), $(this).val());
                });
                
                function loadTurma(idGrade, idPeriodo) {
                    $.ajax
                            ({
                                type: "POST",
                                url: "<? echo application ?>academico/getTurma/",
                                data: "grade=" + idGrade + "&p=" + idPeriodo,
                                cache: false,
                                success: function(data)
                                {
                                    $("#turma").html(data);
                                    $("#turma").show();
                                }
                            });
                }
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
                    <h1>Executar Relatório</h1>
                    <div class="submenus">
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee" style="margin-top: -20px">
                        <form id="form" target="_blank" action="<?= $uri ?>resultReport" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-6-12" style="margin-left: -4px">
                                    <label>CPF</label>
                                    <input id="cpf" name="cpf" type="text" value="" maxlength="14" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Matricula</label>
                                    <input id="matricula" name="matricula" type="text" value="" maxlength="10" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <label>Estrutura Curricular</label>
                                <select id="grade" name="grade" style="text-align: left">
                                    <option value="0">Selecione ...</option>
                                    <? $classFunction['funcoesHTML']->createOptions($data['grades']) ?>
                                </select>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Período:</label>
                                    <select id="periodo" name="periodo">
                                        <? $classFunction['funcoesHTML']->createOptionsValidate($data['periodoAtual'], $data['periodos']) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-6-12" style="margin-left: -4px">
                                    <label>Turma<em class="formee-req">*</em></label>
                                    <select id="turma" name="turma">
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <label>Relatório</label>
                                <select id="report" name="report">
                                    <? $classFunction['funcoesHTML']->createOptions($data['reports']) ?>
                                </select>
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
