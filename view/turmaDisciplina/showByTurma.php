<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#editButton").click(function() {
                    $("#editForm").submit();
                });
                $("#listTurmaDisciplinaButton").click(function() {
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
                    <h1>Mostrar Turma Disciplina</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>listByTurma/?turma=<? echo $data['turma']['id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                            <a href="<?= $uri ?>create/?turma=<? echo $data['turma']['id']; ?>">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Cadastrar</span>
                            </a>
                            <a href="<?= application ?>horario/listByTurma/?td=<? echo $data['turmaDisciplina']['id']; ?>" >
                                <img src="<?= image ?>icons/time.png" />
                                <span>Horários</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee">
                        <label>
                            <span class="legenda">Disciplina:</span>
                            <br />
                            <span class="texto"><? echo $data['turmaDisciplina']['codDisciplina'] . " - " . $data['turmaDisciplina']['disciplina']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Período:</span>
                            <br />
                            <span class="texto"><? echo $data['turmaDisciplina']['periodo']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Inicio:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['data']->dataUSAToDataBrasil($data['turmaDisciplina']['inicio']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Término:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['data']->dataUSAToDataBrasil($data['turmaDisciplina']['inicio']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Fórmula:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['turmaDisciplina']['formula'], $classFunction['formula']->loadOpcoes()); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Vagas:</span>
                            <br />
                            <span class="texto"><? echo $data['turmaDisciplina']['vagas']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Aceita choque de Horários:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumSimNao($data['turmaDisciplina']['horario']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Status:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumStatus($data['turmaDisciplina']['status']); ?></span>
                        </label>
                        <div class="grid-4-12">
                            <input id="editButton" class="left" type="button" title="Editar a <?php echo $action; ?>" value="Editar" />
                        </div>
                        <form id="editForm" action="<?= $uri ?>editByTurma" method="POST">
                            <input type="hidden" name="id" value="<? echo $data['turmaDisciplina']['id']; ?>" />
                        </form>
                    </div>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
        <form id="listTurmaDisciplinaForm" action="<?= application ?>turmaDisciplina/list" method="POST">
            <input type="hidden" name="turma" value="<? echo $data['dados']['id']; ?>" />
        </form>
    </body>
</html>
