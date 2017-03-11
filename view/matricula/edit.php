<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>validationEngine/css/jquery.validationEngine.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>jquery-ui-1.9.2.custom/css/start/jquery-ui-1.9.2.custom.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
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
                $("#deleteButton").click(function() {
                    if (confirm("Tem certeza que deseja deletar?")) {
                        $("#deleteForm").submit();
                    }
                });
                $("#trancarButton").click(function() {
                    if (confirm("Tem certeza que deseja trancar a Matricula?")) {
                        $("#trancarForm").submit();
                    }
                });
                $("#cpfResponsavel").mask("999.999.999-99");
                $('#cpfResponsavel').autocomplete(
                        {
                            source: "<? echo application; ?>pessoa/searchPessoa/?type=cpf",
                            minLength: 2,
                            select: function(event, ui) {
                                $("#cpfResponsavel").val(ui.item.cpf);
                                $("#nomeResponsavel").val(ui.item.nome);
                                $("#responsavel").val(ui.item.value);
                                return false;
                            }
                        });
                $('#nomeResponsavel').autocomplete(
                        {
                            source: "<? echo application; ?>pessoa/searchPessoa/?type=nome",
                            minLength: 2,
                            select: function(event, ui) {
                                $("#cpfResponsavel").val(ui.item.cpf);
                                $("#nomeResponsavel").val(ui.item.nome);
                                $("#responsavel").val(ui.item.value);
                                return false;
                            }
                        });
                $("#alterToResponsavel").click(function() {
                    $("#cpfResponsavel").val("");
                    $("#cpfResponsavel").attr("disabled", false);
                    $("#nomeResponsavel").val("");
                    $("#nomeResponsavel").attr("disabled", false);
                    $("#alterToResponsavel").hide();
                });
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
                    <h1>Editar Matricula do Aluno</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>list">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
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
                    <div class="conteudo formee" style="margin-bottom: 0">
                        <label style="width: 120px">
                            <span class="legenda">R.A.:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['matricula']; ?></span>
                        </label>
                        <label  style="width: 400px">
                            <span class="legenda">Nome:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['nome']; ?></span>
                        </label>
                        <label  style="width: 400px">
                            <span class="legenda">Período:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['periodo']; ?></span>
                        </label>
                        <label  style="width: 400px">
                            <span class="legenda">Turma:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['turma']; ?></span>
                        </label>
                        <label  style="width: 400px">
                            <span class="legenda">Plano de Pagamento:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['plano']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Situação:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['dados']['situacao'], $classFunction['situacaoPeriodo']->loadOpcoes()); ?></span>
                        </label>
                    </div>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>UPDATE" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>CPF Responsável <em class="formee-req">*</em></label>
                                    <input id="cpfResponsavel" disabled="disabled" name="cpfResponsavel" type="text" value="<? echo $data['dados']['cpfResponsavel']; ?>" maxlength="14" />
                                </div>
                                <div class="grid-8-12" style="margin-left: 8px">
                                    <label>Nome Responsável <em class="formee-req">*</em></label>
                                    <input id="nomeResponsavel"  disabled="disabled" name="nomeResponsavel" type="text" value="<? echo $data['dados']['responsavel']; ?>" />
                                </div>
                                <div class="grid-12-12" style="text-align: left">
                                    <a id="alterToResponsavel" href="#" title="Alterar o Responsável">Alterar o Responsável</a>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Status<em class="formee-req">*</em></label>
                                    <select id="status" name="status">
                                        <option value="1" <? echo $classFunction['funcoesHTML']->validateSelect($data['dados']['status'], "1"); ?>>Ativo</option>
                                        <option value="0" <? echo $classFunction['funcoesHTML']->validateSelect($data['dados']['status'], "0"); ?>>Inativo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Observa&ccedil;&atilde;o</label>
                                    <textarea id="observacao" name="observacao" id="" cols="30" rows="10"><? echo $data['dados']['observacao']; ?></textarea>
                                </div>
                            </div>
                            <div class="grid-8-12">
                                <input type="hidden" name="id" value="<? echo $data['dados']['id']; ?>" />
                                <input id="responsavel" type="hidden" name="responsavel" value="<? echo $data['dados']['responsavel_id']; ?>" />
                                <input id="deleteButton" class="left" type="button" title="Deletar a <?php echo $action; ?>" value="Deletar" />
                                <?
                                if ($data['dados']['situacao'] == "MT") {
                                    ?>
                                    <input id="trancarButton" class="left" type="button" title="Destrancar a Matricula" value="Destrancar Matricula" />
                                    <?
                                } else {
                                    ?>
                                    <input id="trancarButton" class="left" type="button" title="Trancar a Matricula" value="Trancar Matricula" />
                                    <?
                                }
                                ?>
                                <input class="left" type="submit" title="Salvar a <?php echo $action; ?>" value="Salvar" />
                            </div>
                        </form>
                        <form id="deleteForm" action="<?php echo $uri . "DELETE"; ?>" method="POST">
                            <input type="hidden" name="id" value="<? echo $data['dados']['id']; ?>" />
                        </form>
                        <form id="trancarForm" action="<?php echo $uri . "TRANCAR"; ?>" method="POST">
                            <input type="hidden" name="id" value="<? echo $data['dados']['id']; ?>" />
                            <input type="hidden" name="situacao" value="<? echo $data['dados']['situacao']; ?>" />
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
