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
                $("#matricula").keypress(verificaNumero);
                $("#dataOcorrenciaInit").mask("99/99/9999");
                $("#horaOcorrenciaInit").mask("99:99");
                $("#dataOcorrenciaEnd").mask("99/99/9999");
                $("#horaOcorrenciaEnd").mask("99:99");
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
                    <h1>Buscar Ocorrências Bancárias</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri; ?>loadRetorno">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Processar Arquivo</span>
                            </a>
                            <a href="<?= $uri ?>listRetorno">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee">
                        <form id="form" target="_blank" action="<?= $uri ?>reportSearchRetorno" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Nosso Número</label>
                                    <input id="nossoNumero" name="nossoNumero" type="text" value="" maxlength="13" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-5-12" style="margin-left: -4px">
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
                                <label>Nome do Sacado</label>
                                <input id="nome" name="nome" type="text" value="" />
                            </div>
                            <div class="grid-12-12">
                                <div style="width: 320px; float: left; margin-right: 40px">
                                    <div class="grid-8-12" style="margin-left: -4px">
                                        <label>Data da Ocorrência Inicial</label>
                                        <input id="dataOcorrenciaInit" name="dataOcorrenciaInit" type="text" value="" maxlength="10" />
                                    </div>
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Hora Inicial</label>
                                        <input id="horaOcorrenciaInit" name="horaOcorrenciaInit" type="text" value="" maxlength="5" />
                                    </div>
                                </div>
                                <div style="width: 320px; float: left">
                                    <div class="grid-8-12" style="margin-left: -4px">
                                        <label>Data da Ocorrência Final</label>
                                        <input id="dataOcorrenciaEnd" name="dataOcorrenciaEnd" type="text" value="" maxlength="10" />
                                    </div>
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Hora Final</label>
                                        <input id="horaOcorrenciaEnd" name="horaOcorrenciaEnd" type="text" value="" maxlength="5" />
                                    </div>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <label>Descrição da Ocorrência</label>
                                <input id="descricaoOcorrencia" name="descricaoOcorrencia" type="text" value="" />
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-6-12" style="margin-left: -4px">
                                    <label>Usuário Operador</label>
                                    <select id="usuario" name="usuario">
                                        <option value="%">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptions($data['usuarios']); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-4-12">
                                <input class="left" type="submit" title="Buscar a Ocorrência Bancária" value="Buscar" />
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
