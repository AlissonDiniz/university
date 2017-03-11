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
            jQuery(document).ready(function() {
                $("#botao").hide();
                $("#grade").change(function() {
                    if ($(this).val() === "%") {
                        $("#botao").hide();
                        $("#divTurmas").hide();
                    } else {
                        loadTurmas($(this).val(), $("#periodo").val());
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
                                $("#botao").show();
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
                    <h1>Fechar Diários</h1>
                    <div class="submenus">
                        <p>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee" style="margin-top: -10px">
                        <form id="form" action="<?= $uri ?>FECHARDIARIO" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-12-12" style="margin-left: -4px">
                                    <label>Estrutura Curricular<em class="formee-req">*</em></label>
                                    <select id="grade" name="grade">
                                        <option value="%">Selecione...</option>
                                        <? $classFunction['funcoesHTML']->createOptions($data['grades']) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Período<em class="formee-req">*</em></label>
                                    <select id="periodo" name="periodo">
                                        <? $classFunction['funcoesHTML']->createOptions($data['parametros']); ?>
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
                            <div class="grid-4-12">
                                <input id="botao" class="left" type="submit" title="Fechar os Diários" value="Fechar" />
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
