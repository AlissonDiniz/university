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
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine-pt.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                $("#inicio").mask("99/99/9999");
                $("#termino").mask("99/99/9999");
                jQuery("#form").validationEngine();
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
                    <h1>Criar Turma Disciplina</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>listByTurma/?turma=<? echo $data['turma']['id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-bottom: 20px">
                        <label style="width: 140px">
                            <span class="legenda">C&oacute;digo da Estrutura:</span>
                            <br />
                            <span class="texto"><? echo $data['turma']['codGrade']; ?></span>
                        </label>
                        <label style="width: 140px">
                            <span class="legenda">C&oacute;digo da Turma:</span>
                            <br />
                            <span class="texto"><? echo $data['turma']['codigo']; ?></span>
                        </label>
                        <label style="width: 50px">
                            <span class="legenda">Per&iacute;odo:</span>
                            <br />
                            <span class="texto"><? echo $data['turma']['periodo']; ?></span>
                        </label>
                    </div>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>SAVE" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Disciplina:<em class="formee-req">*</em></label>
                                    <select id="disciplina" name="disciplina">
                                        <? $classFunction['funcoesHTML']->createOptions($data['disciplinas']) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Inicio<em class="formee-req">*</em></label>
                                    <input id="inicio" name="inicio" class="validate[required] text-input" type="text" value="<? echo $classFunction['data']->dataUSAToDataBrasil($data['periodo']['inicio']); ?>" maxlength="10" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Término<em class="formee-req">*</em></label>
                                    <input id="termino" name="termino" class="validate[required] text-input" type="text" value="<? echo $classFunction['data']->dataUSAToDataBrasil($data['periodo']['termino']); ?>" maxlength="10" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Vagas<em class="formee-req">*</em></label>
                                    <input id="vagas" name="vagas" class="validate[required] text-input" type="text" value="50" maxlength="3" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-6-12" style="margin-left: -4px">
                                    <label>F&oacute;rmula<em class="formee-req">*</em></label>
                                    <select id="formula" name="formula">
                                        <? $classFunction['funcoesHTML']->createOptionsValidate("3CF", $classFunction['formula']->loadOpcoes()) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Aceita Choque de Horários<em class="formee-req">*</em></label>
                                    <select id="horario" name="horario">
                                        <option value="0">Não</option>
                                        <option value="1">Sim</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Status<em class="formee-req">*</em></label>
                                    <select id="status" name="status">
                                        <option value="1">Ativo</option>
                                        <option value="0">Inativo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-4-12">
                                <input id="turma" type="hidden" name="turma" value="<? echo $data['turma']['id']; ?>" />
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
