<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>validationEngine/css/jquery.validationEngine.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine-pt.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $("#deleteButton").click(function() {
                    if (confirm("Tem certeza que deseja deletar?")) {
                        $("#deleteForm").submit();
                    }
                });
                jQuery("#form").validationEngine();
            });
            function tecla(objeto, event) {
                var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
                if ((keyCode > 47 && keyCode < 58) && check(objeto.value)) {
                    return true;
                } else {
                    if (keyCode == 46 || keyCode == 8 || keyCode == 0 || keyCode == 37 || keyCode == 39) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
            function verificaNota(objeto) {
                if (objeto.value > 10) {
                    alert("Não é permitido nota maior que 10!");
                    objeto.value = null;
                    return false;
                } else {
                    return true;
                }
            }
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
                    <h1>Editar Notas da Turma Disciplina do Aluno</h1>
                    <div class="submenus">
                        <p>
                            <a href="<? echo $uri ?>show/<? echo $data['matriculaTurmaDisciplina']['id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-bottom: 5px">
                        <label>
                            <span class="legenda">Aluno:</span>
                            <br />
                            <span class="texto"><? echo $data['matricula']['matricula'] . " - " . $data['matricula']['nome']; ?></span>
                        </label>
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
                    </div>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>UPDATE" method="POST">
                            <?
                            foreach ($data['matriculaTurmaDisciplina']['notas'] as $value) {
                                ?>
                                <div class="grid-12-12">
                                    <div class="grid-3-12" style="margin-left: -4px">
                                        <label>Nota <? echo $value['label']; ?>:</label>
                                        <input id="notas[<? echo $value['numeroEtapa']; ?>]" name="notas[<? echo $value['numeroEtapa']; ?>]" type="text" value="<? echo $classFunction['number']->formatNota($value['valor']); ?>" maxlength="4" onkeypress="return tecla(this, event)" onblur="verificaNota(this)" />
                                    </div>
                                </div>
                                <?
                            }
                            ?>
                            <div class="grid-4-12">
                                <input type="hidden" name="id" value="<? echo $data['matriculaTurmaDisciplina']['id']; ?>" />
                                <input class="left" type="submit" title="Salvar a <?php echo $action; ?>" value="Salvar" />
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
