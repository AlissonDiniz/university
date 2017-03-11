<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>validationEngine/css/jquery.validationEngine.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine-pt.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                $("#codigo").mask("9999.9");
                $("#inicio").mask("99/99/9999");
                $("#termino").mask("99/99/9999");
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
                    <h1>Criar Turma</h1>
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
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>SAVE" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-12-12" style="margin-left: -4px">
                                    <label>Estrutura Curricular<em class="formee-req">*</em></label>
                                    <select id="grade" name="grade">
                                        <? $classFunction['funcoesHTML']->createOptions($data['grades']) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Turma<em class="formee-req">*</em></label>
                                    <select id="turma" name="turma">
                                        <? $classFunction['funcoesHTML']->createOptions($classFunction['turma']->loadOpcoes()) ?>
                                    </select>
                                </div>
                            </div>                            
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>M&oacute;dulo:<em class="formee-req">*</em></label>
                                    <select id="modulo" name="modulo">
                                        <? $classFunction['funcoesHTML']->createOptions($classFunction['modulo']->loadOpcoes()) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Turno<em class="formee-req">*</em></label>
                                    <select id="turno" name="turno">
                                        <? $classFunction['funcoesHTML']->createOptions($classFunction['turno']->loadOpcoes()) ?>
                                    </select>
                                </div>
                            </div>                            
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Período:<em class="formee-req">*</em></label>
                                    <select id="periodo" name="periodo">
                                        <? $classFunction['funcoesHTML']->createOptionsValidate($data['periodoAtual'], $data['periodos']) ?>
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
                                <input class="left" type="submit" title="Salvar a <?php echo $action; ?>" value="Salvar" />
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
