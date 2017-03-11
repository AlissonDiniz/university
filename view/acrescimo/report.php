<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "search.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskMoney.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $('#valor').maskMoney();
                $("#nossoNumero").keypress(verificaNumero);
                $("#matricula").keypress(verificaNumero);
                $("#grade").change(function() {
                    if ($(this).val() === "%") {
                        $("#divTurmas").hide();
                    } else {
                        loadTurmas($(this).val(), $("#periodo").val());
                    }
                });
                $("#periodo").change(function() {
                    if ($(this).val() === "%") {
                        $("#divTurmas").hide();
                    } else {
                        loadTurmas($("#grade").val(), $(this).val());
                    }
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
                    <h1>Relatório de Acréscimos</h1>
                    <div class="submenus">
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee" style="margin-top: -20px">
                        <div class="formulario formee">
                            <form id="form" action="<?= $uri ?>resultReport" target="_blank" method="POST">
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
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Nosso Número</label>
                                        <input id="nossoNumero" name="nossoNumero" type="text" value="" maxlength="11" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Matricula do Aluno</label>
                                        <input id="matricula" name="matricula" type="text" value="" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <label>Nome do Aluno</label>
                                    <input id="nome" name="nome" type="text" value="" />
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-2-12" style="margin-left: -4px">
                                        <label>Parcela<em class="formee-req">*</em></label>
                                        <select id="parcela" name="parcela">
                                            <option value="%">Todas</option>
                                            <? $classFunction['funcoesHTML']->createOptions($classFunction['numbers']->loadOpcoes()) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-3-12" style="margin-left: -4px">
                                        <label>Valor</label>
                                        <input id="valor" name="valor" type="text" value="" maxlength="7" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-2-12" style="margin-left: -4px">
                                        <label>Status</label>
                                        <select id="status" name="status">
                                            <option value="%">Todos</option>
                                            <option value="1">Ativo</option>
                                            <option value="0">Inativo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-4-12">
                                    <input class="left" type="submit" title="Gerar Relatório" value="Gerar Relatório" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
    </body>
</html>
