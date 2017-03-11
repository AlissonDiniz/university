<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>validationEngine/css/jquery.validationEngine.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>jquery-ui-1.9.2.custom/css/start/jquery-ui-1.9.2.custom.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "list.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskMoney.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $('#valor').maskMoney();
                jQuery("#form").validationEngine();
            });
            function validate() {
                var status = false;
                $('.checkBox').each(function() {
                    if (!status) {
                        if (this.checked) {
                            status = true;
                        }
                    }
                });
                if (status) {
                    $("#divSubmit").show();
                } else {
                    $("#divSubmit").hide();
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
                    <h1>Criar Acréscimo - Escolher Títulos</h1>
                    <div class="submenus">
                        <p>
                            <a href="<? echo $uri ?>create">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-bottom: 0">
                        <label style="width: 90px">
                            <span class="legenda">R.A.:</span>
                            <br />
                            <span class="texto"><? echo $data['matricula']['matricula']; ?></span>
                        </label>
                        <label style="width: 450px">
                            <span class="legenda">Nome:</span>
                            <br />
                            <span class="texto"><? echo $data['matricula']['nome']; ?></span>
                        </label>
                        <label style="width: 100px">
                            <span class="legenda">Período:</span>
                            <br />
                            <span class="texto"><? echo $data['matricula']['periodo']; ?></span>
                        </label>
                    </div>
                    <div class="formulario formee" style="margin-left: 10px">
                        <form id="form" action="<?= $uri ?>SAVE" method="POST">
                            <div style="margin-left: -10px">
                                <table id="mytable" cellspacing="0" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <td width="100" colspan="2">Matricula</td>
                                            <td width="300" style="text-align: left; padding-left: 40px">Nome do Aluno:</td>
                                            <td width="80" style="font-size: 0.6em">Nosso Número</td>
                                            <td width="80">Valor</td>
                                            <td width="80" style="font-size: 0.6em">Vencimento</td>
                                            <td width="80" style="font-size: 0.5em">Situação</td>
                                            <td width="80" style="border-right: none; font-size: 0.6em">Status</td>
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
                                                    <td width="20">
                                                        <?
                                                        if ($line['dados']['situacao'] != "1" && $line['dados']['status'] != "0") {
                                                            ?>
                                                            <input class="checkBox" onclick="validate()" type="checkbox" name="titulos[]" value="<?php echo $line['dados']['id']; ?>" />
                                                            <?
                                                        }
                                                        ?>
                                                    </td>
                                                    <td width="80"><?php echo $line['dados']['matricula']; ?></td>
                                                    <td width="300" style="text-align: left"><?php echo $line['dados']['nome']; ?></td>
                                                    <td width="80"><?php echo $line['dados']['nosso_numero']; ?></td>
                                                    <td width="80"><?php echo $classFunction["number"]->formatMoney($line['dados']['valor']); ?></td>
                                                    <td width="80"><?php echo $classFunction["data"]->dataUSAToDataBrasil($line['dados']['vencimento']); ?></td>
                                                    <td width="80"><?php echo $classFunction["enum"]->enumOpcoes($line['dados']['situacao'], $classFunction["situacaoTitulo"]->loadOpcoes()); ?></td>
                                                    <td width="80" style="border-right: none"><?php echo $classFunction["enum"]->enumStatus($line['dados']['status']); ?></td>
                                                </tr>

                                                <?php
                                            } else {
                                                $linha = 0;
                                                ?>
                                                <tr>
                                                    <th width="20">
                                                        <?
                                                        if ($line['dados']['situacao'] != "1" && $line['dados']['status'] != "0") {
                                                            ?>
                                                            <input class="checkBox" onclick="validate()" type="checkbox" name="titulos[]" value="<?php echo $line['dados']['id']; ?>" />
                                                            <?
                                                        }
                                                        ?>
                                                    </th>
                                                    <th width="80"><?php echo $line['dados']['matricula']; ?></th>
                                                    <th width="300" style="text-align: left"><?php echo $line['dados']['nome']; ?></th>
                                                    <th width="80"><?php echo $line['dados']['nosso_numero']; ?></th>
                                                    <th width="80"><?php echo $classFunction["number"]->formatMoney($line['dados']['valor']); ?></th>
                                                    <th width="80"><?php echo $classFunction["data"]->dataUSAToDataBrasil($line['dados']['vencimento']); ?></th>
                                                    <th width="80"><?php echo $classFunction["enum"]->enumOpcoes($line['dados']['situacao'], $classFunction["situacaoTitulo"]->loadOpcoes()); ?></th>
                                                    <th width="80" style="border-right: none"><?php echo $classFunction["enum"]->enumStatus($line['dados']['status']); ?></th>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>

                                </table>
                            </div>
                            <div id="divSubmit" style="display: none">
                                <div class="grid-12-12">
                                    <div class="grid-3-12" style="margin-left: -4px">
                                        <label>Valor<em class="formee-req">*</em></label>
                                        <input id="valor" name="valor" class="validate[required] text-input" type="text" value="" />
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
                                <div class="grid-12-12">
                                    <input id="formButton" class="left" type="submit" title="Avançar" value="Avançar" />
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
    </body>
</html>
