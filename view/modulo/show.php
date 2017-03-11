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
                    <h1>Mostrar Módulo</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>list/?grade=<? echo $data['modulo']['grade_id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                            <a id="listDisciplinaButton" href="#">
                                <img src="<?= image ?>icons/page_copy.png" />
                                <span>Disciplinas do Módulo</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee">
                        <label>
                            <span class="legenda">C&oacute;digo da Estrutura:</span>
                            <br />
                            <span class="texto"><? echo $data['modulo']['codGrade']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">C&oacute;digo:</span>
                            <br />
                            <span class="texto"><? echo $data['modulo']['codigo']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Descrição:</span>
                            <br />
                            <span class="texto"><? echo $data['modulo']['descricao']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Carga Horária:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['number']->formatNumber($data['modulo']['carga_horaria']); ?></span>
                        </label>
                        <div class="grid-1-12">
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
        <form id="listDisciplinaForm" action="<?= application ?>moduloDisciplina/list" method="POST">
            <input type="hidden" name="modulo" value="<? echo $data['dados']['id']; ?>" />
        </form>
    </body>
</html>
