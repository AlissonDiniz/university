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
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $("#dataInicial").mask("99/99/9999");
                $("#dataFinal").mask("99/99/9999");
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
                    <h1>Relatório - Alunos Matriculados</h1>
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
                                    <? $classFunction['funcoesHTML']->createOptions($data['grades']) ?>
                                </select>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Período:</label>
                                    <select id="periodo" name="periodo">
                                        <option value="%">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptionsValidate($data['periodoAtual'], $data['periodos']) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Turma<em class="formee-req">*</em></label>
                                    <select id="turma" name="turma">
                                        <option value="%">Todas</option>
                                        <? $classFunction['funcoesHTML']->createOptions($classFunction['turma']->loadOpcoes()) ?>
                                    </select>
                                </div>
                            </div> 
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>R.A.</label>
                                    <input id="matricula" name="matricula" type="text" value="" maxlength="10" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Período de Ingresso:</label>
                                    <select id="periodoIngresso" name="periodoIngresso">
                                        <option value="%">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptions($data['periodos']) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-5-12" style="margin-left: -4px">
                                    <label>Situação:</label>
                                    <select id="situacao" name="situacao">
                                        <option value="%">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptions($classFunction['situacaoPeriodo']->loadOpcoes()) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Data Inicial</label>
                                    <input id="dataInicial" name="dataInicial" type="text" value="01/<? echo date("m/Y"); ?>" maxlength="10" />
                                </div>
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Data Final</label>
                                    <input id="dataFinal" name="dataFinal" type="text" value="<? echo date("d/m/Y"); ?>" maxlength="10" />
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
