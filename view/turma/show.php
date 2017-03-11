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
        <script type="text/javascript">
            $(document).ready(function(){
                $("#editButton").click(function(){
                    $("#editForm").submit();
                });
                $("#listTurmaDisciplinaButton").click(function(){
                    $("#listTurmaDisciplinaForm").submit();
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
                    <h1>Mostrar Turma</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>create">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Cadastrar</span>
                            </a>
                            <a href="<?= $uri ?>list">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                            <a href="<?= $uri ?>search">
                                <img src="<?= image ?>icons/zoom.png" />
                                <span>Pesquisar</span>
                            </a>
                            <a id="listTurmaDisciplinaButton" href="#">
                                <img src="<?= image ?>icons/frontpage.png" />
                                <span>Turmas Disciplinas</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee">
                        <label>
                            <span class="legenda">C&oacute;digo:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['codigo']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Estrutura Curricular:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['codGrade'] . " - " . $data['dados']['nomeCurso']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Per&iacute;odo:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['periodo']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Turma:</span>
                            <br />
                            <span class="texto"><? echo substr($data['dados']['codigo'], 7, 2); ?></span>
                        </label>
                        <label>
                            <span class="legenda">M&oacute;dulo:</span>
                            <br />
                            <span class="texto"><? echo substr($data['dados']['codigo'], 5, 2); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Turno:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumOpcoes(substr($data['dados']['codigo'], 9, 1), $classFunction['turno']->loadOpcoes()); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Observa&ccedil;&atilde;o:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['observacao']; ?></span>
                        </label>
                        <div class="grid-4-12">
                            <input id="editButton" class="left" type="button" title="Editar a <?php echo $action; ?>" value="Editar" />
                        </div>
                        <form id="editForm" action="<?= $uri ?>edit" method="POST">
                            <input type="hidden" name="id" value="<? echo $data['dados']['id']; ?>" />
                        </form>
                    </div>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
        <form id="listTurmaDisciplinaForm" action="<?= application ?>turmaDisciplina/listByTurma" method="POST">
            <input type="hidden" name="turma" value="<? echo $data['dados']['id']; ?>" />
        </form>
    </body>
</html>
