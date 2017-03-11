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
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskMoney.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
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
                $('#valorPago').maskMoney();
                $('#valorPago').keyup(function() {
                    recalcular();
                });
                $('#valorMulta').maskMoney();
                $('#valorMulta').keyup(function() {
                    recalcular();
                });
                $('#valorJuros').maskMoney();
                $('#valorJuros').keyup(function() {
                    recalcular();
                });
                $('#valorDesconto').maskMoney();
                $('#valorDesconto').keyup(function() {
                    recalcular();
                });
                $("#dataPagamento").mask("99/99/9999");
                recalcular();
                jQuery("#form").validationEngine();
            });

            function salvar() {
                valorAPagar = parseFloat($("#valorAPagar").val().replace(",", ""));
                valorMulta = parseFloat($("#valorMulta").val().replace(",", ""));
                valorJuros = parseFloat($("#valorJuros").val().replace(",", ""));
                valorDesconto = parseFloat($("#valorDesconto").val().replace(",", ""));
                valorRecebido = (valorAPagar + valorMulta + valorJuros) - valorDesconto;
                valorPago = parseFloat($("#valorPago").val().replace(",", ""));
                if (isNaN(valorPago)) {
                    valorPago = 0;
                }
                if (valorRecebido > 0) {
                    if (valorPago > 0) {
                        $("#form").submit();
                    } else {
                        alert("O Valor pago não pode ser menor ou igual a R$ 0.00!");
                    }
                } else {
                    $("#form").submit();
                }
            }

            function recalcular() {
                valorAPagar = parseFloat($("#valorAPagar").val().replace(",", ""));
                valorMulta = parseFloat($("#valorMulta").val().replace(",", ""));
                valorJuros = parseFloat($("#valorJuros").val().replace(",", ""));
                valorDesconto = parseFloat($("#valorDesconto").val().replace(",", ""));
                valorRecebido = (valorAPagar + valorMulta + valorJuros) - valorDesconto;

                if (isNaN(valorRecebido) || valorRecebido < 0) {
                    $("#valorRecebido").text(0.00);
                } else {
                    $("#valorRecebido").text(valorRecebido.toFixed(2));
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
                    <h1>Editar Baixa</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>list">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                            <a href="<?= $uri ?>search">
                                <img src="<?= image ?>icons/zoom.png" />
                                <span>Pesquisar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee">
                        <label>
                            <span class="legenda">Matricula do Aluno:</span>
                            <br />
                            <span class="texto"><? echo $data['baixa']['dados']['matricula']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Nome do Aluno:</span>
                            <br />
                            <span class="texto"><? echo $data['baixa']['dados']['nome']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Nosso Número:</span>
                            <br />
                            <span class="texto"><? echo $data['baixa']['dados']['nosso_numero']; ?></span>
                        </label>
                    </div>
                    <div class="formulario formee" style="margin-top: -30px">
                        <form id="form" action="<?= $uri ?>UPDATE" method="POST">
                            <div style="float: left; width: 100%">
                                <div class="grid-9-12">
                                    <div class="grid-3-12" style="margin-left: -4px">
                                        <label>Valor do Título</label>
                                        <input id="valorAPagar" name="valorAPagar" type="text" disabled="disabled" value="<? echo $classFunction['number']->formatCurrency($data['baixa']['dados']['valorTitulo'] + $data['baixa']['dados']['valor_desconto']); ?>" />
                                    </div>
                                    <div class="grid-3-12">
                                        <label>Valor Multa</label>
                                        <input id="valorMulta" name="valorMulta" type="text" value="<? echo $classFunction['number']->formatCurrency($data['baixa']['dados']['valor_multa']); ?>" />
                                    </div>
                                    <div class="grid-3-12">
                                        <label>Valor Juros</label>
                                        <input id="valorJuros" name="valorJuros" type="text" value="<? echo $classFunction['number']->formatCurrency($data['baixa']['dados']['valor_juros']); ?>" />
                                    </div>
                                    <div class="grid-3-12">
                                        <label>Valor Descontos</label>
                                        <input id="valorDesconto" name="valorDesconto" type="text" value="<? echo $classFunction['number']->formatCurrency($data['baixa']['dados']['valor_desconto']); ?>" />
                                    </div>
                                </div>
                                <div class="grid-2-12" style="width: 150px; margin: 7px 0 0 5px">
                                    <label>Valor à Receber</label>
                                    <div style="float: left; margin-top: 10px; font-size: 20px; font-weight: bold">
                                        R$
                                        <span id="valorRecebido" ></span>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Valor Pago<em class="formee-req">*</em></label>
                                    <input id="valorPago" name="valorPago" class="validate[required] text-input" type="text" value="<? echo $classFunction['number']->formatCurrency($data['baixa']['dados']['valor_pago']); ?>" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Data do Pagamento<em class="formee-req">*</em></label>
                                    <input id="dataPagamento" name="dataPagamento" class="validate[required] text-input" type="text" value="<? echo $classFunction["data"]->dataUSAToDataBrasil($data['baixa']['dados']['data_pagamento']); ?>" maxlength="10" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Forma de Pagamento</label>
                                    <select id="formaPagamento" name="formaPagamento">
                                        <? $classFunction['funcoesHTML']->createOptionsValidate($data['baixa']['dados']['forma_pagamento_id'], $data['formasPagamento']); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Observa&ccedil;&atilde;o</label>
                                    <textarea id="observacao" name="observacao" id="" cols="30" rows="10"><? echo $data['baixa']['dados']['observacao']; ?></textarea>
                                </div>
                            </div>
                            <div class="grid-4-12">
                                <input type="hidden" name="id" value="<? echo $data['baixa']['dados']['id']; ?>" />
                                <input id="deleteButton" class="left" type="button" title="Deletar a <?php echo $action; ?>" value="Deletar" />
                                <input class="left" type="button" onclick="salvar()" title="Salvar a <?php echo $action; ?>" value="Salvar" />
                            </div>
                        </form>
                        <form id="deleteForm" action="<?php echo $uri . "DELETE"; ?>" method="POST">
                            <input type="hidden" name="id" value="<? echo $data['baixa']['dados']['id']; ?>" />
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
