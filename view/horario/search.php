<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                $("#cpf").mask("999.999.999-99");
                $("#inicio").mask("99:99");
                $("#termino").mask("99:99");
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
                    <h1>Buscar Horário</h1>
                    <div class="submenus">
                        <p>
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
                                    <label>C&oacute;digo da Turma</label>
                                    <input id="codigoTurma" name="codigoTurma" type="text" value="" maxlength="10" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>C&oacute;digo da Disciplina</label>
                                    <input id="codigoDisciplina" name="codigoDisciplina" type="text" value="" maxlength="7" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <label>Nome da Disciplina</label>
                                <input id="nomeDisciplina" name="nomeDisciplina" type="text" value="" />
                            </div>
                            <div class="grid-12-12">
                                <label>Nome do Professor</label>
                                <input id="nomeProfessor" name="nomeProfessor" type="text" value="" />
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Hora Inicial:</label>
                                    <input id="inicio" name="inicio" type="text" value="" maxlength="5" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Hora Final:</label>
                                    <input id="termino" name="termino" type="text" value="" maxlength="5" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Sala</label>
                                    <select id="sala" name="sala">
                                        <option value="%">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptions($data['salas']) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Dia da Semana</label>
                                    <select id="dia" name="dia">
                                        <option value="%">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptions($classFunction['diaSemana']->loadOpcoes()) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Turno</label>
                                    <select id="turno" name="turno">
                                        <option value="%">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptions($classFunction['turno']->loadOpcoes()) ?>
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
