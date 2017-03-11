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
            jQuery(document).ready(function() {
                $("#cpf").mask("999.999.999-99");
                $('#cpf').autocomplete(
                        {
                            source: "<? echo application; ?>aluno/searchAluno/?type=cpf",
                            minLength: 2,
                            select: function(event, ui) {
                                $("#cpf").val(ui.item.cpf);
                                $("#nome").val(ui.item.nome);
                                $("#aluno").val(ui.item.value);
                                loadTurma($("#aluno").val(), $("#periodo").val());
                                $("#divSubmit").show();
                                return false;
                            }
                        });
                $('#nome').autocomplete(
                        {
                            source: "<? echo application; ?>aluno/searchAluno/?type=nome",
                            minLength: 2,
                            select: function(event, ui) {
                                $("#cpf").val(ui.item.cpf);
                                $("#nome").val(ui.item.nome);
                                $("#aluno").val(ui.item.value);
                                loadTurma($("#aluno").val(), $("#periodo").val());
                                $("#divSubmit").show();
                                return false;
                            }
                        });

                function loadTurma(idAluno, idPeriodo) {
                    $.ajax
                            ({
                                type: "POST",
                                url: "<? echo $uri ?>getTurmasTransferir/",
                                data: "aluno=" + idAluno + "&p=" + idPeriodo,
                                cache: false,
                                success: function(data)
                                {
                                    $("#turma").html(data);
                                }
                            });
                }
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
                    <h1>Transferir Aluno de Turma</h1>
                    <div class="submenus">
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee" style="margin-top: -10px">
                        <form id="form" action="<?= $uri ?>SAVETRANSFERIR" method="POST">
                            <div class="grid-3-12">
                                <div class="grid-12-12" style="margin-left: -4px">
                                    <label>CPF do Aluno</label>
                                    <input id="cpf" name="cpf" type="text" value="" maxlength="14" />
                                </div>
                            </div>
                            <div class="grid-8-12">
                                <div class="grid-12-12" style="margin: -2px 0 0 4px">
                                    <label>Nome do Aluno</label>
                                    <input id="nome" name="nome" type="text" value="" />
                                </div>
                            </div>
                            <div id="divSubmit" style="display: none">
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Turma<em class="formee-req">*</em></label>
                                        <select id="turma" name="turma">
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-4-12">
                                    <input id="periodo" type="hidden" name="periodo" value="<?= $data['parametros']['dados']['periodo_matricula_id']; ?>" />
                                    <input id="aluno" type="hidden" name="aluno" value="" />
                                    <input class="left" type="submit" title="Transferir Aluno" value="Transferir" />
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
