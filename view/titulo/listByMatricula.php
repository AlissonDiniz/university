<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "list.css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $("#buttonRegenarate").click(function() {
                    if (confirm("Tem certeza que deseja regerar todas as parcelas?")) {
                        $("#formRegenarate").submit();
                    }
                });
                $(".chk-titulo").click(function(){
                    var checked = false;
                    $(".chk-titulo").each(function(){
                        if($(this).is(':checked')){
                           checked = true; 
                        }
                    });
                    if(checked){
                       $("#printTitulos").show(); 
                    }else{
                        $("#printTitulos").hide();
                    }
                });
                $("#printTitulos").click(function() {
                    var ids = "";
                    var separator = "";
                    var form = $("#formPrintTitulos");
                    $(".chk-titulo").each(function(){
                        if($(this).is(':checked')){
                            ids = ids +separator+ $(this).val();
                            separator = "-";
                        }
                    });
                    form.find("input").val(ids);
                    form.submit();
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
                    <h1>Listar Títulos do Aluno</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= application ?>matricula/show/<? echo $data['matricula']['id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                            <a id="buttonRegenarate" href="#">
                                <img src="<?= image ?>icons/recurring.png" />
                                <span>Regerar os Títulos</span>
                            </a>
                        </p>
                    </div>
                    <?
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-bottom: 10px">
                        <label style="width: 110px">
                            <span class="legenda">R.A.:</span>
                            <br />
                            <span class="texto"><? echo $data['matricula']['matricula']; ?></span>
                        </label>
                        <label  style="width: 400px">
                            <span class="legenda">Nome:</span>
                            <br />
                            <span class="texto"><? echo $data['matricula']['nome']; ?></span>
                        </label>
                        <label  style="width: 80px">
                            <span class="legenda">Período:</span>
                            <br />
                            <span class="texto"><? echo $data['matricula']['periodo']; ?></span>
                        </label>
                    </div>
                    <div>
                        <table id="mytable" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <td width="160" colspan="2">Matricula</td>
                                    <td width="500" style="text-align: left; padding-left: 20px">Nome do Aluno:</td>
                                    <td width="80" style="font-size: 0.6em">Nosso Número</td>
                                    <td width="80">Valor</td>
                                    <td width="80" style="font-size: 0.6em">Valor Restante</td>
                                    <td width="80" style="font-size: 0.6em">Vencime</td>
                                    <td width="80" style="font-size: 0.5em; border-right: none">Situação</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $linha = 0;
                                foreach ($data['titulos'] as $line) {
                                    if ($linha == 0) {
                                        $linha = 1;
                                        ?>
                                        <tr>
                                            <td width="80">
                                                <input style="float: left; margin: 4px 4px 0 -2px" class="chk-titulo" type="checkbox" value="<?php echo $line['dados']['id']; ?>" />
                                                <a href="<?= $uri ?>showByMatricula/<?php echo $line['dados']['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </td>
                                            <td width="80"><?php echo $line['dados']['matricula']; ?></td>
                                            <td width="300" style="text-align: left"><?php echo $line['dados']['nome']; ?></td>
                                            <td width="80"><?php echo $line['dados']['nosso_numero']; ?></td>
                                            <td width="80"><?php echo $classFunction["number"]->formatMoney($line['dados']['valor']); ?></td>
                                            <td width="80"><?php echo $classFunction["number"]->formatMoney($line['dados']['valor_restante']); ?></td>
                                            <td width="80"><?php echo $classFunction["data"]->dataUSAToDataBrasil($line['dados']['vencimento']); ?></td>
                                            <td width="80" style="border-right: none"><?php echo $classFunction["enum"]->enumOpcoes($line['dados']['situacao'], $classFunction["situacaoTitulo"]->loadOpcoes()); ?></td>
                                        </tr>

                                        <?php
                                    } else {

                                        $linha = 0;
                                        ?>
                                        <tr>
                                            <th width="80">
                                                <input style="float: left; margin: 4px 4px 0 -2px" class="chk-titulo" type="checkbox" value="<?php echo $line['dados']['id']; ?>" />
                                                <a href="<?= $uri ?>showByMatricula/<?php echo $line['dados']['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </th>
                                            <th width="80"><?php echo $line['dados']['matricula']; ?></th>
                                            <th width="300" style="text-align: left"><?php echo $line['dados']['nome']; ?></th>
                                            <th width="80"><?php echo $line['dados']['nosso_numero']; ?></th>
                                            <th width="80"><?php echo $classFunction["number"]->formatMoney($line['dados']['valor']); ?></th>
                                            <th width="80"><?php echo $classFunction["number"]->formatMoney($line['dados']['valor_restante']); ?></th>
                                            <th width="80"><?php echo $classFunction["data"]->dataUSAToDataBrasil($line['dados']['vencimento']); ?></th>
                                            <th width="80" style="border-right: none"><?php echo $classFunction["enum"]->enumOpcoes($line['dados']['situacao'], $classFunction["situacaoTitulo"]->loadOpcoes()); ?></th>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="formulario formee" style="margin-left: 10px">
                        <div class="grid-12-12">
                            <input id="printTitulos" class="left" style="display: none" type="button" title="Imrpimir Títulos selecionados" value="Imprimir Lote" />
                        </div>
                    </div>
                    <form id="formRegenarate" action="<?= $uri ?>regenerate" method="POST">
                        <input type="hidden" name="matricula" value="<? echo $data['matricula']['id']; ?>" />
                    </form>
                    <form id="formPrintTitulos" action="<?= application ?>boleto/reportByLote" method="POST" target="_blank">
                        <input type="hidden" name="ids" value="" />
                    </form>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
    </body>
</html>
