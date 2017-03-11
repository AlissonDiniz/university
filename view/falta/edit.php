<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            var quantidadeAulas = <? echo $data['falta']['dados']['aulas']; ?>;
            jQuery(document).ready(function() {
                $("#formButton").click(function() {
                    if (parseInt($("#valor").val()) > quantidadeAulas) {
                        alert("O horário da aula só possui " + quantidadeAulas + " aulas! Não é permitido quantidade de faltas maior que " + quantidadeAulas + "!");
                        $("#valor").focus();
                    } else {
                        if (parseInt($("#valor").val()) < quantidadeAulas && $("#tipo").val() != "F") {
                            alert("Para quantidade de faltas menor que a quantidade de aulas do horário, a situação deverá ser Falta!");
                            $("#tipo").focus();
                        } else {
                            $("#form").submit();
                        }
                    }
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
                    <h1>Editar Faltas na Turma Disciplina</h1>
                    <div class="submenus">
                        <p>
                            <a href="<? echo $uri ?>show/<? echo $data['falta']['dados']['id']; ?>">
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
                    </div>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>UPDATE" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Quant Faltas:</label>
                                    <input id="valor" name="valor" type="text" value="<? echo $data['falta']['dados']['valor']; ?>" maxlength="1" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Situação:<em class="formee-req">*</em></label>
                                    <select id="tipo" name="tipo">
                                        <option value="P" <? echo $classFunction['funcoesHTML']->validateSelect($data['falta']['dados']['tipo'], "P"); ?>>Presença</option>
                                        <option value="F" <? echo $classFunction['funcoesHTML']->validateSelect($data['falta']['dados']['tipo'], "F"); ?>>Falta</option>
                                        <option value="A" <? echo $classFunction['funcoesHTML']->validateSelect($data['falta']['dados']['tipo'], "A"); ?>>Atestado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-4-12">
                                <input type="hidden" name="id" value="<? echo $data['falta']['dados']['id']; ?>" />
                                <input id="formButton" class="left" type="button" title="Salvar a <?php echo $action; ?>" value="Salvar" />
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
