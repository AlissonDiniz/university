<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
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
                    <h1>Buscar Turma</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>create">
                                <img src="<?= image ?>icons/zoom.png" />
                                <span>Cadastrar</span>
                            </a>
                            <a href="<?= $uri ?>list">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>result" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>C&oacute;digo</label>
                                    <input id="codigo" name="codigo" type="text" value="" maxlength="10" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>M&oacute;dulo</label>
                                    <select id="modulo" name="modulo">
                                        <option value="__">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptions($classFunction['modulo']->loadOpcoes()) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Turma</label>
                                    <select id="turma" name="turma">
                                        <option value="__">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptions($classFunction['turma']->loadOpcoes()) ?>
                                    </select>
                                </div>
                            </div>                            
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Turno</label>
                                    <select id="turno" name="turno">
                                        <option value="_">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptions($classFunction['turno']->loadOpcoes()) ?>
                                    </select>
                                </div>
                            </div>                            
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Período</label>
                                    <select id="periodo" name="periodo">
                                        <option value="%">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptions($data['periodos']) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-4-12">
                                <input class="left" type="submit" title="Buscar a <?php echo $action; ?>" value="Buscar" />
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
