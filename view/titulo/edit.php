<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>validationEngine/css/jquery.validationEngine.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskMoney.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine-pt.js"></script>
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
                $('#valor').maskMoney();
                $("#vencimento").mask("99/99/9999");
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
                    <h1>Editar Título</h1>
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
                    <div class="conteudo formee">
                        <label>
                            <span class="legenda">Matricula do Aluno:</span>
                            <br />
                            <span class="texto"><? echo $data['titulo']['dados']['matricula']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Nome do Aluno:</span>
                            <br />
                            <span class="texto"><? echo $data['titulo']['dados']['nome']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Nosso Número:</span>
                            <br />
                            <span class="texto"><? echo $data['titulo']['dados']['nosso_numero']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Linha Digitável:</span>
                            <br />
                            <span class="texto"><? echo $data['titulo']['dados']['linha_digitavel']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Situação:</span>
                            <br />
                            <span class="texto"><? echo $classFunction["enum"]->enumOpcoes($data['titulo']['dados']['situacao'], $classFunction["situacaoTitulo"]->loadOpcoes()); ?></span>
                        </label>
                    </div>
                    <div class="formulario formee" style="margin-top: -30px">
                        <form id="form" action="<?= $uri ?>UPDATE" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-10-12" style="margin-left: -4px">
                                    <label>Configuração Bancária<em class="formee-req">*</em></label>
                                    <select id="configuracao" name="configuracao">
                                        <? $classFunction['funcoesHTML']->createOptionsValidate($data['titulo']['dados']['idConfiguracao'], $data['configuracao']) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Valor<em class="formee-req">*</em></label>
                                    <input id="valor" name="valor" class="validate[required] text-input" type="text" value="<? echo $classFunction['number']->formatCurrency($data['titulo']['dados']['valor']); ?>" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Data de Vecimento<em class="formee-req">*</em></label>
                                    <input id="vencimento" name="vencimento" class="validate[required] text-input" type="text" value="<? echo $classFunction["data"]->dataUSAToDataBrasil($data['titulo']['dados']['vencimento']); ?>" maxlength="10" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Status<em class="formee-req">*</em></label>
                                    <select id="status" name="status">
                                        <option value="1" <? echo $classFunction['funcoesHTML']->validateSelect($data['titulo']['dados']['status'], "1"); ?>>Ativo</option>
                                        <option value="0" <? echo $classFunction['funcoesHTML']->validateSelect($data['titulo']['dados']['status'], "0"); ?>>Inativo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Observa&ccedil;&atilde;o</label>
                                    <textarea id="observacao" name="observacao" id="" cols="30" rows="10"><? echo $data['titulo']['dados']['observacao']; ?></textarea>
                                </div>
                            </div>
                            <div class="grid-4-12">
                                <input type="hidden" name="id" value="<? echo $data['titulo']['dados']['id']; ?>" />
                                <input id="deleteButton" class="left" type="button" title="Deletar a <?php echo $action; ?>" value="Deletar" />
                                <input class="left" type="submit" title="Salvar a <?php echo $action; ?>" value="Salvar" />
                            </div>
                        </form>
                        <form id="deleteForm" action="<?php echo $uri . "DELETE"; ?>" method="POST">
                            <input type="hidden" name="id" value="<? echo $data['titulo']['dados']['id']; ?>" />
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
