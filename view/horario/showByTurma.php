<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "list.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#editButton").click(function(){
                    $("#editForm").submit();
                });
                $("#listDisciplinaButton").click(function(){
                    $("#listDisciplinaForm").submit();
                });
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
                    <h1>Mostrar Horário</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>listByTd/?td=<? echo $data['turmaDisciplina']['id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                            <a href="<?= $uri ?>create/?td=<? echo $data['turmaDisciplina']['id']; ?>">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Cadastrar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee">
                        <label style="width: 100px">
                            <span class="legenda">C&oacute;digo:</span>
                            <br />
                            <span class="texto"><? echo $data['turmaDisciplina']['codDisciplina']; ?></span>
                        </label>
                        <label style="width: 300px">
                            <span class="legenda">Nome Disciplina:</span>
                            <br />
                            <span class="texto"><? echo $data['turmaDisciplina']['disciplina']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Professor:</span>
                            <br />
                            <span class="texto"><? echo $data['horario']['professor']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Sala:</span>
                            <br />
                            <span class="texto"><? echo $data['horario']['sala']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Turno:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['horario']['turno'], $classFunction['turno']->loadOpcoes()); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Hora Inicial:</span>
                            <br />
                            <span class="texto"><? echo $data['horario']['inicio']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Hora Final:</span>
                            <br />
                            <span class="texto"><? echo $data['horario']['termino']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Aulas:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['horario']['aulas'], $classFunction['aulas']->loadOpcoes()); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Dia da Semana:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['horario']['dia'], $classFunction['diaSemana']->loadOpcoes()); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Observação:</span>
                            <br />
                            <span class="texto"><? echo $data['horario']['observacao']; ?></span>
                        </label>
                        <div class="grid-1-12">
                            <input id="editButton" class="left" type="button" title="Editar a <?php echo $action; ?>" value="Editar" />
                        </div>
                        <form id="editForm" action="<?= $uri ?>editByTd" method="POST">
                            <input type="hidden" name="id" value="<? echo $data['dados']['id']; ?>" />
                        </form>
                    </div>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
        <form id="listDisciplinaForm" action="<?= application ?>moduloDisciplina/list" method="POST">
            <input type="hidden" name="modulo" value="<? echo $data['dados']['id']; ?>" />
        </form>
    </body>
</html>
