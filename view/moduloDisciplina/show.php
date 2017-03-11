<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
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
                    <h1>Mostrar Disciplina no Módulo</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>list/?modulo=<? echo $data['moduloDisciplina']['modulo_id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee">
                        <label>
                            <span class="legenda">Código Disciplina:</span>
                            <br />
                            <span class="texto"><? echo $data['moduloDisciplina']['codigo']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Nome Disciplina:</span>
                            <br />
                            <span class="texto"><? echo $data['moduloDisciplina']['nome']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Carga Horária:</span>
                            <br />
                            <span class="texto"><? echo $data['moduloDisciplina']['carga_horaria']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Obrigatória:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumObrigatorio($data['moduloDisciplina']['obrigatorio']); ?></span>
                        </label>
                        <div class="grid-1-12">
                            <input id="editButton" class="left" type="button" title="Editar a Disciplina no Modulo" value="Editar" />
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
        <form id="listDisciplinaForm" action="<?= $uri ?>listDisciplina" method="POST">
            <input type="hidden" name="modulo" value="<? echo $data['dados']['id']; ?>" />
        </form>
    </body>
</html>
