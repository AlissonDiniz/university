<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>validationEngine/css/jquery.validationEngine.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "create.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine-pt.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function() {
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
                    <h1>Criar Arquivo de Remessa</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>listRemessa">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                            <a href="<?= $uri ?>searchRemessa">
                                <img src="<?= image ?>icons/zoom.png" />
                                <span>Pesquisar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>CREATEARQUIVO" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-12-12" style="margin-left: -4px">
                                    <label>Curso<em class="formee-req">*</em></label>
                                    <select id="curso" name="curso">
                                        <option value="%">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptions($data['cursos']); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Configuração Bancária<em class="formee-req">*</em></label>
                                    <select id="configuracao" name="configuracao">
                                        <? $classFunction['funcoesHTML']->createOptions($data['configuracao']); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-12-12" style="margin-left: -4px">
                                    <label>Parcela<em class="formee-req">*</em></label>
                                    <? $classFunction['funcoesHTML']->createCheckBox($classFunction['meses']->loadOpcoes(), "meses"); ?>
                                </div>
                            </div>
                            <div class="grid-4-12">
                                <input class="left" type="submit" title="Criar arquivo de remessa" value="Criar Arquivo" />
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
