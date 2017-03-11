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
            $(document).ready(function(){
                $("#deleteButton").click(function(){
                    if(confirm("Tem certeza que deseja deletar?")){
                        $("#deleteForm").submit();
                    }
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
                    <h1>Mostrar Matricula na Disciplina</h1>
                    <div class="submenus">
                        <p>
                            <a id="listDisciplinaButton" href="#">
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
                            <span class="legenda">R.A.:</span>
                            <br />
                            <span class="texto"><? echo $data['matricula']['matricula']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Nome:</span>
                            <br />
                            <span class="texto"><? echo $data['matricula']['nome']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Período:</span>
                            <br />
                            <span class="texto"><? echo $data['matricula']['periodo']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Disciplina:</span>
                            <br />
                            <span class="texto"><? echo $data['matriculaTurmaDisciplina']['codDisciplina'] . " - " . $data['matriculaTurmaDisciplina']['disciplina']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Resultado Parcial:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['number']->formatNota($data['matriculaTurmaDisciplina']['resultado']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Resultado Final:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['number']->formatNota($data['matriculaTurmaDisciplina']['resultado_final']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Conceito:</span>
                            <br />
                            <span class="texto"><? echo $data['matriculaTurmaDisciplina']['conceito']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Situação:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['matriculaTurmaDisciplina']['situacao'], $classFunction['situacaoDisciplina']->loadOpcoes()); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Status:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumStatus($data['matriculaTurmaDisciplina']['status']); ?></span>
                        </label>
                        <div class="grid-4-12">
                            <input id="deleteButton" class="left" type="button" title="Deletar a Dispensa" value="Deletar" />
                        </div>
                        <form id="deleteForm" action="<?= $uri ?>DELETED" method="POST">
                            <input type="hidden" name="id" value="<? echo $data['matriculaTurmaDisciplina']['id']; ?>" />
                        </form>
                    </div>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
        <form id="listDisciplinaForm" action="<?= $uri ?>list" method="POST">
            <input type="hidden" name="m" value="<? echo $data['matriculaTurmaDisciplina']['matricula_id']; ?>" />
        </form>
    </body>
</html>
