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
                $("#inicio").mask("99:99");
                $("#termino").mask("99:99");
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
                    <h1>Editar Horário</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>showByTd/<? echo $data['horario']['id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                            <a href="<?= $uri ?>listByTd/?td=<? echo $data['turmaDisciplina']['id']; ?>">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-bottom: 0">
                        <label style="width: 100px">
                            <span class="legenda">C&oacute;digo:</span>
                            <br />
                            <span class="texto"><? echo $data['turmaDisciplina']['codDisciplina']; ?></span>
                        </label>
                        <label style="width: 300px">
                            <span class="legenda">Nome Disciplina:</span>
                            <br />
                            <span class="texto"><? echo $data['turmaDisciplina']['disciplina']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Professor:</span>
                            <br />
                            <span class="texto"><? echo $data['horario']['professor']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Turno:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['horario']['turno'], $classFunction['turno']->loadOpcoes()); ?></span>
                        </label>
                    </div>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>UPDATEBYTD" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Sala<em class="formee-req">*</em></label>
                                    <select id="sala" name="sala">
                                        <? $classFunction['funcoesHTML']->createOptionsValidate($data['horario']['sala_id'], $data['salas']); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Hora Inicial:<em class="formee-req">*</em></label>
                                    <input id="inicio" name="inicio" type="text" class="validate[required] text-input" value="<? echo $data['horario']['inicio']; ?>" maxlength="5" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Hora Final:<em class="formee-req">*</em></label>
                                    <input id="termino" name="termino" type="text" class="validate[required] text-input" value="<? echo $data['horario']['termino']; ?>" maxlength="5" />
                                </div>
                            </div>
                            <div class="conteudo formee" style="margin: 0">
                                <label>
                                    <span class="legenda">Aulas:</span>
                                    <br />
                                    <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['horario']['aulas'], $classFunction['aulas']->loadOpcoes()); ?></span>
                                </label>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Dia da Semana<em class="formee-req">*</em></label>
                                    <select id="dia" name="dia">
                                        <? $classFunction['funcoesHTML']->createOptionsValidate($data['horario']['dia'], $classFunction['diaSemana']->loadOpcoes()); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Observa&ccedil;&atilde;o</label>
                                    <textarea id="observacao" name="observacao" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="grid-4-12">
                                <input type="hidden" name="professor" value="<? echo $data['horario']['professor_id']; ?>" />
                                <input type="hidden" name="id" value="<? echo $data['horario']['id']; ?>" />
                                <input id="deleteButton" class="left" type="button" title="Deletar a <?php echo $action; ?>" value="Deletar" />
                                <input class="left" type="submit" title="Salvar a <?php echo $action; ?>" value="Salvar" />
                            </div>
                        </form>
                        <form id="deleteForm" action="<?php echo $uri . "DELETEBYTD"; ?>" method="POST">
                            <input type="hidden" name="id" value="<? echo $data['horario']['id']; ?>" />
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
