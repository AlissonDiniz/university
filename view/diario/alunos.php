<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "search.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $("#turma").hide();
                $("#turmaDisciplina").hide();
                $("#horario").hide();
                $("#grade").change(function() {
                    if (this.value != "0") {
                        loadTurma(this.value, $("#periodo").val());
                    }
                });
                $("#periodo").change(function() {
                    loadTurma($("#grade").val(), $(this).val());
                });
                $("#turma").change(function() {
                    if (this.value != "0") {
                        loadTurmaDisciplina(this.value);
                    }
                });
                function loadTurma(idGrade, idPeriodo) {
                    $("#turmaDisciplina").hide();
                    $("#turmaDisciplina").html("");
                    $("#horario").hide();
                    $("#horario").html("");
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
                function loadTurmaDisciplina(idTurma) {
                    $("#horario").hide();
                    $("#horario").html("");
                    $.ajax
                            ({
                                type: "POST",
                                url: "<? echo $uri ?>getTurmaDisciplina/",
                                data: "turma=" + idTurma,
                                cache: false,
                                success: function(data)
                                {
                                    $("#turmaDisciplina").html(data);
                                    $("#turmaDisciplina").show();
                                }
                            });
                }
                function loadHorario(idTurmaDisciplina) {
                    $.ajax
                            ({
                                type: "POST",
                                url: "<? echo $uri ?>getHorario/",
                                data: "turmaDisciplina=" + idTurmaDisciplina,
                                cache: false,
                                success: function(data)
                                {
                                    if (data != "") {
                                        $("#horario").html(data);
                                        $("#horario").show();
                                    }
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
                    <h1>Relatório - Diário - Alunos Matriculados</h1>
                    <div class="submenus">
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee" style="margin-top: -20px">
                        <form id="form" target="_blank" action="<?= $uri ?>resultReportAlunos" method="POST">
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
                                <label>Turma Disciplina<em class="formee-req">*</em></label>
                                <select id="turmaDisciplina" name="turmaDisciplina">
                                </select>
                            </div>
                            <div class="grid-10-12">
                                <label>Horário<em class="formee-req">*</em></label>
                                <select id="horario" name="horario">
                                    <option value="0">Selecione ...</option>
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
