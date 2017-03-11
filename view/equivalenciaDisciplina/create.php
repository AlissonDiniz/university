<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "create.css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $("#listDisciplinaButton").click(function() {
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
                    <h1>Lançar Equivalência de Disciplinas</h1>
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
                    <div class="conteudo formee" style="margin-bottom: 10px">
                        <label style="width: 110px">
                            <span class="legenda">R.A.:</span>
                            <br />
                            <span class="texto"><? echo $data['aluno']['dados']['matricula']; ?></span>
                        </label>
                        <label  style="width: 500px">
                            <span class="legenda">Nome:</span>
                            <br />
                            <span class="texto"><? echo $data['aluno']['dados']['nome']; ?></span>
                        </label>
                    </div>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>SAVE" method="POST">
                            <div class="grid-10-12">
                                <label>Disciplina Origem:<em class="formee-req">*</em></label>
                                <select id="disciplinaEquivalente" name="disciplinaEquivalente">
                                    <? $classFunction['funcoesHTML']->createOptions($data['disciplina']) ?>
                                </select>
                            </div>
                            <div class="grid-10-12">
                                <label>Disciplina Equivalente:<em class="formee-req">*</em></label>
                                <select id="matriculaTurmaDisciplina" name="matriculaTurmaDisciplina">
                                    <? $classFunction['funcoesHTML']->createOptions($data['disciplinaEQ']) ?>
                                </select>
                            </div>
                            <div class="grid-12-12">
                                <input type="hidden" name="aluno" value="<? echo $data['aluno']['dados']['id']; ?>" />
                                <input class="left" type="submit" title="Salvar a Equivalência" value="Salvar" />
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
        <form id="listDisciplinaForm" action="<?= $uri ?>list" method="POST">
            <input type="hidden" name="aluno" value="<? echo $data['aluno']['dados']['id']; ?>" />
        </form>
    </body>
</html>
