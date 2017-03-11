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
            jQuery(document).ready(function(){
                $("#deleteButton").click(function(){
                    if(confirm("Tem certeza que deseja deletar, você estará deletando também as notas e faltas desta disciplina?")){
                        $("#deleteForm").submit();
                    }
                });
                $("#listDisciplinaButton").click(function(){
                    $("#listDisciplinaForm").submit();
                });
            });
            
            function tecla(objeto, event) {
                var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
                if((keyCode > 47 && keyCode < 58) && check(objeto.value)){
                    return true;
                }else{
                    if(keyCode == 46 || keyCode == 8 || keyCode == 0 || keyCode == 37 || keyCode == 39){
                        return true;
                    }else{
                        return false;
                    }
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
                    <h1>Editar Matricula na Disciplina</h1>
                    <div class="submenus">
                        <p>
                            <a href="<? echo $uri; ?>show/<? echo $data['matriculaTurmaDisciplina']['id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                            <a id="listDisciplinaButton" href="#">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-bottom: 0">
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
                    </div>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>UPDATE" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Resultado Parcial:</label>
                                    <input id="resultado" name="resultado" type="text" value="<? echo $classFunction['number']->formatNota($data['matriculaTurmaDisciplina']['resultado']); ?>" maxlength="4" onkeypress="return tecla(this, event)" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Resultado Final:</label>
                                    <input id="resultadoFinal" name="resultadoFinal" type="text" value="<? echo $classFunction['number']->formatNota($data['matriculaTurmaDisciplina']['resultado_final']); ?>" maxlength="4" onkeypress="return tecla(this, event)" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-6-12" style="margin-left: -4px">
                                    <label>Situação:<em class="formee-req">*</em></label>
                                    <select id="situacao" name="situacao">
                                        <option value="EC" <? echo $classFunction['funcoesHTML']->validateSelect($data['matriculaTurmaDisciplina']['situacao'], "EC"); ?>>Em Curso</option>
                                        <option value="AP" <? echo $classFunction['funcoesHTML']->validateSelect($data['matriculaTurmaDisciplina']['situacao'], "AP"); ?>>Aprovado</option>
                                        <option value="RE" <? echo $classFunction['funcoesHTML']->validateSelect($data['matriculaTurmaDisciplina']['situacao'], "RE"); ?>>Reprovado</option>
                                        <option value="RF" <? echo $classFunction['funcoesHTML']->validateSelect($data['matriculaTurmaDisciplina']['situacao'], "RF"); ?>>Repr P/ Falta</option>
                                        <option value="CO" <? echo $classFunction['funcoesHTML']->validateSelect($data['matriculaTurmaDisciplina']['situacao'], "CO"); ?>>Complemento</option>
                                        <option value="PE" <? echo $classFunction['funcoesHTML']->validateSelect($data['matriculaTurmaDisciplina']['situacao'], "PE"); ?>>Pendente</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Status:<em class="formee-req">*</em></label>
                                    <select id="status" name="status">
                                        <option value="1" <? echo $classFunction['funcoesHTML']->validateSelect($data['matriculaTurmaDisciplina']['status'], "1"); ?>>Ativo</option>
                                        <option value="0" <? echo $classFunction['funcoesHTML']->validateSelect($data['matriculaTurmaDisciplina']['status'], "0"); ?>>Inativo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-4-12">
                                <input type="hidden" name="id" value="<? echo $data['matriculaTurmaDisciplina']['id']; ?>" />
                                <input id="deleteButton" class="left" type="button" title="Deletar a <?php echo $action; ?>" value="Deletar" />
                                <input class="left" type="submit" title="Salvar a <?php echo $action; ?>" value="Salvar" />
                            </div>
                        </form>
                        <form id="deleteForm" action="<?php echo $uri . "DELETE"; ?>" method="POST">
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
