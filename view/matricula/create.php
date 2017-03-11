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
                                loadPlano($("#aluno").val(), $("#periodo").val());
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
                                loadPlano($("#aluno").val(), $("#periodo").val());
                                $("#divSubmit").show();
                                return false;
                            }
                        });

                function loadTurma(idAluno, idPeriodo) {
                    $.ajax
                            ({
                                type: "POST",
                                url: "<? echo $uri ?>getTurma/",
                                data: "aluno=" + idAluno + "&p=" + idPeriodo,
                                cache: false,
                                success: function(data)
                                {
                                    $("#turma").html(data);
                                }
                            });
                }

                function loadPlano(idAluno, idPeriodo) {
                    $.ajax
                            ({
                                type: "POST",
                                url: "<? echo $uri ?>getPlano/",
                                data: "aluno=" + idAluno + "&p=" + idPeriodo,
                                cache: false,
                                success: function(data)
                                {
                                    $("#plano").html(data);
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
                    <h1>Matricular Aluno</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>list">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                            <a href="<?= $uri ?>createPessoa">
                                <img src="<?= image ?>icons/user.png" />
                                <span>Criar Aluno</span>
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
                                        <label>Período<em class="formee-req">*</em></label>
                                        <select id="periodo" name="periodo">
                                            <? $classFunction['funcoesHTML']->createOptions($data['parametros']); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Turma<em class="formee-req">*</em></label>
                                        <select id="turma" name="turma">
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <label>Plano de Pagamento<em class="formee-req">*</em></label>
                                    <select id="plano" name="plano">
                                    </select>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Situação:<em class="formee-req">*</em></label>
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
                                            <option value="0">Inativo</option>
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
                                    <input id="aluno" type="hidden" name="aluno" value="" />
                                    <input class="left" type="submit" title="Matricular o Aluno" value="Avançar" />
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
