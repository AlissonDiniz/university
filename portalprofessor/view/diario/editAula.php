<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "list.css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "edit.css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <script type="text/javascript" src="<?= js ?>aula/create.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            var quantidadeAulas = <? echo $data['aula']['dados']['aulas'] ?>;
            var alunosQuantidadeAulas = new Array();
            jQuery(document).ready(function() {
                $("#salvaButton").click(function() {
                    if ($("#conteudo").val() != "") {
                        $("#form").submit();
                    } else {
                        alert("O Conteúdo da Aula deve ser preenchido!");
                        $("#conteudo").focus();
                    }
                });
                $("#listAulaButton").click(function() {
                    $("#listAulaForm").submit();
                });
                $("#deleteButton").click(function() {
                    if (confirm("Tem certeza que deseja deletar?")) {
                        $("#deleteForm").submit();
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
                    <h1>Editar Aula da Disciplina</h1>
                    <div class="submenus">
                        <p>
                            <a id="listAulaButton" href="#">
                                <img src="<?= image ?>icons/control_rewind_blue.png" />
                                <span>Voltar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-top: 0; margin-bottom: 10px">
                        <label style="width: 500px">
                            <span class="legenda">Disciplina:</span>
                            <br />
                            <span class="texto"><? echo $data['turmaDisciplina']['dados']['codDisciplina'] . " - " . $data['turmaDisciplina']['dados']['disciplina']; ?></span>
                        </label>
                        <label style="width: 100px">
                            <span class="legenda">Per&iacute;odo:</span>
                            <br />
                            <span class="texto"><? echo $data['turmaDisciplina']['dados']['periodo']; ?></span>
                        </label>
                    </div>
                    <form id="form" action="<?= $uri ?>UPDATEAULA" method="POST">
                        <div class="formulario formee" style="margin-bottom: 30px">
                            <div class="grid-12-12">
                                <label>Conteúdo:<em class="formee-req">*</em></label>
                                <textarea id="conteudo" name="conteudo" cols="30" rows="10"><? echo $data['aula']['dados']['conteudo']; ?></textarea>
                            </div>
                        </div>
                        <div class="conteudo formee" style="margin-top: -20px">
                            <label>
                                <span class="legenda">Horário:</span>
                                <br />
                                <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['aula']['dados']['dia'], $classFunction['diaSemana']->loadOpcoes()) . " | " . $data['aula']['dados']['inicio'] . " - " . $data['aula']['dados']['termino'] . " | " . $data['aula']['dados']['sala'] . " | A: " . $data['aula']['dados']['aulas']; ?></span>
                            </label>
                            <label>
                                <span class="legenda">Data:</span>
                                <br />
                                <span class="texto"><? echo $classFunction['data']->dataUSAToDataBrasil($data['aula']['dados']['data_aula']); ?></span>
                            </label>
                        </div>
                        <div>
                            <table id="mytable" cellspacing="0" cellpadding="5">
                                <thead>
                                    <tr>
                                        <td width="80">FOTO</td>
                                        <td width="80">R.A.</td>
                                        <td width="350" style="text-align: left">Nome:</td>
                                        <td width="100">
                                            <span style="margin-right: 30px">P</span>
                                            <span>F</span>
                                        </td>
                                        <td width="70" style="border-right: none">QuanT</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;
                                    $linha = 0;
                                    foreach ($data['faltas'] as $line) {
                                        if ($linha == 0) {
                                            $linha = 1;
                                            ?>
                                            <tr>
                                                <td width="80">
                                                    <img alt="" src="<?= profile . "?id=" . base64_encode($line['dados']['cpf']) ?>" width="30" height="35" />
                                                </td>
                                                <td width="80"><?php echo $line['dados']['matricula']; ?></td>
                                                <td width="350" style="text-align: left"><?php echo $line['dados']['nome']; ?></td>
                                                <td width="100">
                                                    <input id="<? echo $line['dados']['id']; ?>P" name="alunos[<? echo $line['dados']['id']; ?>]" style="margin-right: 30px" type="radio" value="P" <? echo $classFunction['funcoesHTML']->validateChecked("P", $line['dados']['tipo']); ?> />
                                                    <input id="<? echo $line['dados']['id']; ?>F" name="alunos[<? echo $line['dados']['id']; ?>]" type="radio" value="F" <? echo $classFunction['funcoesHTML']->validateChecked("F", $line['dados']['tipo']); ?> />
                                                </td>
                                                <td width="70" style="border-right: none">
                                                    <span title="Diminuir Aulas" style="font-size: 30px; cursor: pointer" onclick="editarQuantidadeAula(quantidadeAulas, '<? echo $line['dados']['id']; ?>', 'menos')">-</span>
                                                    <span id="spanAula<? echo $line['dados']['id']; ?>" style="font-size: 25px; margin: 0 5px 0 5px; color: #0000FF"><? echo $line['dados']['valor']; ?></span>
                                                    <input id="valorAula<? echo $line['dados']['id']; ?>" type="hidden" value="" name="qtdAulas[<? echo $line['dados']['id']; ?>]" />
                                                    <span title="Aumentar Aulas" style="font-size: 25px; cursor: pointer" onclick="editarQuantidadeAula(quantidadeAulas, '<? echo $line['dados']['id']; ?>', 'mais')">+</span>                                                   
                                                </td>
                                            </tr>

                                            <?php
                                        } else {

                                            $linha = 0;
                                            ?>
                                            <tr>
                                                <th width="80">
                                                    <img alt="" src="<?= profile . "?id=" . base64_encode($line['dados']['cpf']) ?>" width="30" height="35" />
                                                </th>
                                                <th width="80"><?php echo $line['dados']['matricula']; ?></th>
                                                <th width="350" style="text-align: left"><?php echo $line['dados']['nome']; ?></th>
                                                <th width="100">
                                                    <input id="<? echo $line['dados']['id']; ?>P" name="alunos[<? echo $line['dados']['id']; ?>]" style="margin-right: 30px" type="radio" value="P" <? echo $classFunction['funcoesHTML']->validateChecked("P", $line['dados']['tipo']); ?> />
                                                    <input id="<? echo $line['dados']['id']; ?>F" name="alunos[<? echo $line['dados']['id']; ?>]" type="radio" value="F" <? echo $classFunction['funcoesHTML']->validateChecked("F", $line['dados']['tipo']); ?> />
                                                </th>
                                                <th width="70" style="border-right: none">
                                                    <span title="Diminuir Aulas" style="font-size: 30px; cursor: pointer" onclick="editarQuantidadeAula(quantidadeAulas, '<? echo $line['dados']['id']; ?>', 'menos')">-</span>
                                                    <span id="spanAula<? echo $line['dados']['id']; ?>" style="font-size: 25px; margin: 0 5px 0 5px; color: #0000FF"><? echo $line['dados']['valor']; ?></span>
                                                    <input id="valorAula<? echo $line['dados']['id']; ?>" type="hidden" value="" name="qtdAulas[<? echo $line['dados']['id']; ?>]" />
                                                    <span title="Aumentar Aulas" style="font-size: 25px; cursor: pointer" onclick="editarQuantidadeAula(quantidadeAulas, '<? echo $line['dados']['id']; ?>', 'mais')">+</span>                                                   
                                                </th>
                                            </tr>
                                            <?php
                                        }
                                        $contador++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="formulario formee">
                                <div class="grid-4-12">
                                    <input type="hidden" name="id" value="<? echo $data['aula']['dados']['id']; ?>" />
                                    <input id="deleteButton" class="left" type="button" title="Deletar a <?php echo $action; ?>" value="Deletar" />
                                    <input id="salvaButton"class="left" type="button" title="Salvar a <?php echo $action; ?>" value="Salvar" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
        <form id="listAulaForm" action="<?= $uri ?>listAula" method="POST">
            <input type="hidden" name="id" value="<? echo $data['turmaDisciplina']['dados']['id']; ?>" />
        </form>
        <form id="deleteForm" action="<?php echo $uri . "DELETEAULA"; ?>" method="POST">
            <input type="hidden" name="id" value="<? echo $data['aula']['dados']['id']; ?>" />
        </form>
    </body>
</html>
