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
            $(document).ready(function() {
                $("#editButton").click(function() {
                    $("#editForm").submit();
                });
            });

            function mostra(id) {
                if (id === "divAcademico") {
                    $("#" + id).toggle();
                    $("#" + "divFinanceiro").hide();
                } else {
                    $("#" + id).toggle();
                    $("#" + "divAcademico").hide();
                }
            }
        </script>
        <style type="text/css">
            .divMenu{
                float: left; 
                margin-left: 10px; 
                width: 130px;
            }

            .divSubMenu{
                float: left; 
                width: 170px; 
                position: absolute; 
                padding-left: 10px; 
                margin-top: 30px; 
                background-color: #f2f2f2; 
                display: none;
            }
        </style>
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
                    <h1>Mostrar Matricula do Aluno</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>create">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Nova Matricula</span>
                            </a>
                            <a href="<?= $uri ?>list">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                            <a href="<?= $uri ?>search">
                                <img src="<?= image ?>icons/zoom.png" />
                                <span>Pesquisar</span>
                            </a>
                        <div onmouseover="mostra('divAcademico')" onmouseout="mostra('divAcademico')" class="divMenu">
                            <a href="#" style="margin: 8px 0 8px 0">
                                <img src="<?= image ?>icons/school.png" />
                                <span>Acad&ecirc;micos</span>
                            </a>
                            <div id="divAcademico" class="divSubMenu">
                                <a style="margin: 10px 0 8px 0" href="<?= application ?>matriculaTurmaDisciplina/list/?m=<? echo $data['dados']['id']; ?>">
                                    <img src="<?= image ?>icons/database_add.png" />
                                    <span>Discipl Matriculadas</span>
                                </a>
                                <a style="margin: 10px 0 8px 0" href="<?= application ?>matriculaTurmaDisciplina/listD/?m=<? echo $data['dados']['id']; ?>">
                                    <img src="<?= image ?>icons/page_edit.png" />
                                    <span>Discipl Dispesadas</span>
                                </a>
                            </div>
                        </div>
                        <div onmouseover="mostra('divFinanceiro')" onmouseout="mostra('divFinanceiro')" class="divMenu">
                            <a href="#" style="margin: 10px 0 8px 0">
                                <img src="<?= image ?>icons/money.png" />
                                <span>Financeiro</span>
                            </a>
                            <div id="divFinanceiro" class="divSubMenu">
                                <a style="margin: 8px 0 8px 0" href="<?= application ?>titulo/listByMatricula/?m=<? echo $data['dados']['id']; ?>">
                                    <img src="<?= image ?>icons/newspaper.png" />
                                    <span>Títulos</span>
                                </a>
                            </div>
                        </div>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee">
                        <label style="width: 120px">
                            <span class="legenda">R.A.:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['matricula']; ?></span>
                        </label>
                        <label  style="width: 400px">
                            <span class="legenda">Nome:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['nome']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Responsável:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['responsavel']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Período:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['periodo']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Turma:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['turma']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Plano de Pagamento:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['plano']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Situação:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['dados']['situacao'], $classFunction['situacaoPeriodo']->loadOpcoes()); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Status:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumStatus($data['dados']['status']); ?></span>
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
    </body>
</html>
