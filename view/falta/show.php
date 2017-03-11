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
                $("#voltarButton").click(function(){
                    $("#voltarForm").submit();
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
                    <h1>Mostrar Faltas na Turma Disciplina</h1>
                    <div class="submenus">
                        <p>
                            <a id="voltarButton" href="#">
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
                            <span class="legenda">Disciplina:</span>
                            <br />
                            <span class="texto"><? echo $data['matriculaTurmaDisciplina']['codDisciplina'] . " - " . $data['matriculaTurmaDisciplina']['disciplina']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Período:</span>
                            <br />
                            <span class="texto"><? echo $data['matriculaTurmaDisciplina']['periodo']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Data da Aula:</span>
                            <br />
                            <span class="texto"><?php echo $classFunction['data']->dataUSAToDataBrasil($data['falta']['dados']['data_aula']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Quantidade:</span>
                            <br />
                            <span class="texto"><? echo $data['falta']['dados']['valor']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Situação:</span>
                            <br />
                            <span class="texto"><?php echo $classFunction['enum']->enumOpcoes($data['falta']['dados']['tipo'], $classFunction['situacaoFalta']->loadOpcoes()); ?></span>
                        </label>
                        <div class="grid-4-12">
                            <input id="editButton" class="left" type="button" title="Editar a <?php echo $action; ?>" value="Editar" />
                        </div>
                        <form id="editForm" action="<?= $uri ?>edit" method="POST">
                            <input type="hidden" name="id" value="<? echo $data['falta']['dados']['id']; ?>" />
                        </form>
                    </div>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
        <form id="voltarForm" action="<?= $uri ?>list" method="POST">
            <input type="hidden" name="m" value="<? echo $data['matriculaTurmaDisciplina']['id']; ?>" />
        </form>
    </body>
</html>
