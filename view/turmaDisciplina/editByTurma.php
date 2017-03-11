<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>validationEngine/css/jquery.validationEngine.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "edit.css" ?>" />
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
                $("#deleteButton").click(function(){
                    if(confirm("Tem certeza que deseja deletar?")){
                        $("#deleteForm").submit();
                    }
                });
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
                    <h1>Editar Turma Disciplina</h1>
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
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-bottom: 0">
                        <label>
                            <span class="legenda">Disciplina:</span>
                            <br />
                            <span class="texto"><? echo $data['turmaDisciplina']['codDisciplina'] . " - " . $data['turmaDisciplina']['disciplina']; ?></span>
                        </label>
                    </div>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>UPDATEBYTURMA" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Inicio<em class="formee-req">*</em></label>
                                    <input id="inicio" name="inicio" class="validate[required] text-input" type="text" value="<? echo $classFunction['data']->dataUSAToDataBrasil($data['turmaDisciplina']['inicio']); ?>" maxlength="10" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Término<em class="formee-req">*</em></label>
                                    <input id="termino" name="termino" class="validate[required] text-input" type="text" value="<? echo $classFunction['data']->dataUSAToDataBrasil($data['turmaDisciplina']['termino']); ?>" maxlength="10" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Vagas<em class="formee-req">*</em></label>
                                    <input id="vagas" name="vagas" class="validate[required] text-input" type="text" value="<? echo $data['turmaDisciplina']['vagas']; ?>" maxlength="3" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-6-12" style="margin-left: -4px">
                                    <label>F&oacute;rmula<em class="formee-req">*</em></label>
                                    <select id="formula" name="formula">
                                        <? $classFunction['funcoesHTML']->createOptionsValidate($data['turmaDisciplina']['formula'], $classFunction['formula']->loadOpcoes()) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Aceita Choque de Horários<em class="formee-req">*</em></label>
                                    <select id="horario" name="horario">
                                        <option value="0" <? echo $classFunction['funcoesHTML']->validateSelect($data['turmaDisciplina']['horario'], "0"); ?>>Não</option>
                                        <option value="1" <? echo $classFunction['funcoesHTML']->validateSelect($data['turmaDisciplina']['horario'], "1"); ?>>Sim</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Status<em class="formee-req">*</em></label>
                                    <select id="status" name="status">
                                        <option value="1" <? echo $classFunction['funcoesHTML']->validateSelect($data['turmaDisciplina']['status'], "1"); ?>>Ativo</option>
                                        <option value="0" <? echo $classFunction['funcoesHTML']->validateSelect($data['turmaDisciplina']['status'], "0"); ?>>Inativo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-4-12">
                                <input type="hidden" name="turma" value="<? echo $data['turma']['id']; ?>" />
                                <input type="hidden" name="id" value="<? echo $data['turmaDisciplina']['id']; ?>" />
                                <input id="deleteButton" class="left" type="button" title="Deletar a <?php echo $action; ?>" value="Deletar" />
                                <input class="left" type="submit" title="Salvar a <?php echo $action; ?>" value="Salvar" />
                            </div>
                        </form>
                        <form id="deleteForm" action="<?php echo $uri . "DELETEBYTURMA"; ?>" method="POST">
                            <input type="hidden" name="turma" value="<? echo $data['turma']['id']; ?>" />
                            <input type="hidden" name="id" value="<? echo $data['turmaDisciplina']['id']; ?>" />
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