<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "create.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            function loadTurma(idAluno, idPeriodo){
                $.ajax
                ({
                    type: "POST",
                    url: "<? echo $uri ?>getTurma/",
                    data: "aluno="+idAluno+"&p="+idPeriodo,
                    cache: false,
                    success: function(data)
                    {
                        $("#turma").html(data);
                    } 
                });
            }
            jQuery(document).ready(function(){
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
                    <h1>Matricular Aluno</h1>
                    <div class="submenus" style="margin-bottom: -30px">
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>SAVE" method="POST">
                            <div class="grid-3-12">
                                <div class="grid-12-12" style="margin-left: -4px">
                                    <label>CPF do Aluno</label>
                                    <input id="cpf" name="cpf" disabled="disabled" type="text" value="<? echo $data['aluno']['cpf']; ?>" maxlength="14" />
                                </div>
                            </div>
                            <div class="grid-8-12">
                                <div class="grid-12-12" style="margin: -2px 0 0 4px">
                                    <label>Nome do Aluno</label>
                                    <input id="nome" name="nome" disabled="disabled" type="text" value="<? echo $data['aluno']['nome']; ?>" />
                                </div>
                            </div>
                            <div id="divSubmit">
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Período<em class="formee-req">*</em></label>
                                        <select id="periodo" name="periodo">
                                            <? $classFunction['funcoesHTML']->createOptions($data['parametros']); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Turma<em class="formee-req">*</em></label>
                                        <select id="turma" name="turma">
                                            <? $classFunction['funcoesHTML']->createOptions($data['turma']); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-6-12" style="margin-left: -4px">
                                        <label>Plano de Pagamento<em class="formee-req">*</em></label>
                                        <select id="plano" name="plano">
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Situação:<em class="formee-req">*</em></label>
                                        <select id="situacao" name="situacao">
                                            <option value="ME">Matriculado</option>
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
                                <div class="grid-12-12">
                                    <div class="grid-8-12" style="margin-left: -4px">
                                        <label>Observa&ccedil;&atilde;o</label>
                                        <textarea id="observacao" name="observacao" id="" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="grid-4-12">
                                    <input id="aluno" type="hidden" name="aluno" value="<? echo $data['aluno']['id']; ?>" />
                                    <input class="left" type="submit" title="MAtricular o Aluno" value="Avançar" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
        <script type="text/javascript">
            loadTurma($("#aluno").val(), $("#periodo").val());
        </script>
    </body>
</html>
