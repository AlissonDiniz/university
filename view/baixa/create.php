<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>validationEngine/css/jquery.validationEngine.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>jquery-ui-1.9.2.custom/css/start/jquery-ui-1.9.2.custom.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "create.css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "list.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskMoney.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine-pt.js"></script>
        <script type="text/javascript" src="<?= plugin ?>jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            var opcaoPagamento = 1;
            jQuery(document).ready(function() {
                $('.valorPago').maskMoney();
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
                $("#nossoNumero").keypress(function(e) {
                    if (e.which == 13) {
                        getTitulo(this.value, "nossoNumero");
                    }
                    return verificaNumero(e);
                });
                $("#codigoBarras").keypress(function(e) {
                    if (e.which == 13) {
                        getTitulo(this.value, "codigoBarras");
                    }
                    return verificaNumero(e);
                });
                jQuery("#form").validationEngine();
            });

            function buttonGetTitulo() {
                if ($("#nossoNumero").val() != "") {
                    getTitulo($("#nossoNumero").val(), "nossoNumero");
                } else {
                    getTitulo($("#codigoBarras").val(), "codigoBarras");
                }
            }

            function getTitulo(key, type) {
                $.ajax({
                    url: "<? echo application; ?>titulo/getTitulo",
                    type: "post",
                    dataType: 'json',
                    data: "type=" + type + "&key=" + key,
                    success: function(data) {
                        if (data.length > 0) {
                            $("#idTitulo").val(data[0].id);
                            $("#valorAPagar").val((parseFloat(data[0].valor) + parseFloat(data[0].valorDesconto)).toFixed(2));
                            $("#valorMulta").val(data[0].valorMulta);
                            $("#valorJuros").val(data[0].valorJuros);
                            $("#valorDesconto").val(data[0].valorDesconto);
                            $("#valorRecebido").text(data[0].valor);
                            $("#dataPagamento").val(data[0].data);
                            $("#codigoBarras").val(data[0].codigoBarras);
                            $("#divSubmit").show();
                        } else {
                            alert("Título não encontrado, baixado total ou inativado");
                        }
                    },
                    error: function() {
                        alert("Título não encontrado");
                    }
                });
            }

            function addPagamento() {
                $("#tbodyPagamentos").append('<tr>' + $("#tbodyPagamentos > tr:first").html() + '</tr>');
                $('.valorPago').unbind();
                $('.valorPago').maskMoney();
                $('.valorPago').keyup(function() {
                    recalcular();
                });
                opcaoPagamento = opcaoPagamento + 1;
            }

            function remover(object) {
                if (opcaoPagamento > 1) {
                    $(object).parent().parent().remove();
                    opcaoPagamento = opcaoPagamento - 1;
                } else {
                    alert("Deve existir pelo menos uma opção de pagamento!");
                }
            }

            function salvar() {
                valorAPagar = parseFloat($("#valorAPagar").val().replace(",", ""));
                valorPago = 0;
                $("#tbodyPagamentos > tr").each(function() {
                    valor = parseFloat($(this).find(".valorPago").val().replace(",", ""));
                    if (!isNaN(valor)) {
                        valorPago = valorPago + valor;
                    }
                });
                valorMulta = parseFloat($("#valorMulta").val().replace(",", ""));
                valorJuros = parseFloat($("#valorJuros").val().replace(",", ""));
                valorDesconto = parseFloat($("#valorDesconto").val().replace(",", ""));
                valorRecebido = (valorAPagar + valorMulta + valorJuros) - valorDesconto;
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
                    <h1>Baixar Título</h1>
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
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>SAVE" method="POST">
                            <div class="grid-3-12">
                                <div class="grid-12-12" style="margin-left: -4px">
                                    <label>Nosso Número</label>
                                    <input id="nossoNumero" name="nossoNumero" type="text" value="" maxlength="13" />
                                </div>
                            </div>
                            <div class="grid-8-12" style="width: 472px">
                                <div class="grid-12-12" style="margin: -2px 0 0 4px">
                                    <label>Código de Barras</label>
                                    <input id="codigoBarras" name="codigoBarras" type="text" value="" maxlength="44" />
                                </div>
                            </div>
                            <div style="float: left; margin-top: 33px">
                                <input class="right" onclick="buttonGetTitulo()" type="button" value="?" />
                            </div>
                            <div id="divSubmit" style="display: none">
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Data do Pagamento<em class="formee-req">*</em></label>
                                        <input id="dataPagamento" name="dataPagamento" class="validate[required] text-input" type="text" value="<? echo date("d/m/Y"); ?>" maxlength="10" />
                                    </div>
                                </div>
                                <div style="float: left; width: 100%">
                                    <div class="grid-9-12">
                                        <div class="grid-3-12" style="margin-left: -4px">
                                            <label>Valor do Título</label>
                                            <input id="valorAPagar" name="valorAPagar" type="text" disabled="disabled" value="" />
                                        </div>
                                        <div class="grid-3-12">
                                            <label>Valor Multa</label>
                                            <input id="valorMulta" name="valorMulta" type="text" value="0.00" />
                                        </div>
                                        <div class="grid-3-12">
                                            <label>Valor Juros</label>
                                            <input id="valorJuros" name="valorJuros" type="text" value="0.00" />
                                        </div>
                                        <div class="grid-3-12">
                                            <label>Valor Descontos</label>
                                            <input id="valorDesconto" name="valorDesconto" type="text" value="0.00" />
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
                                <div>
                                    <table id="mytable" style="margin-left: 10px" cellspacing="0" cellpadding="5">
                                        <thead>
                                            <tr>
                                                <td width="200">A Valor Pago</td>
                                                <td width="450">Forma de Pagamento</td>
                                                <td width="50" style="border-right: none"></td>
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyPagamentos">
                                            <tr id="trDefault">
                                                <td width="200">
                                                    <div class="grid-10-12">
                                                        <input class="valorPago" name="arrayValorPago[]" class="validate[required] text-input" type="text" value="0.00" />
                                                    </div>
                                                </td>
                                                <td width="450">
                                                    <div class="grid-12-12" style="margin-left: -4px">
                                                        <select id="formaPagamento" name="arrayFormaPagamento[]">
                                                            <? $classFunction['funcoesHTML']->createOptions($data['formasPagamento']); ?>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td width="50" style="border-right: none">
                                                    <img alt="" style="width: 20px; cursor: pointer" onclick="remover(this)" src="<?= image ?>icons/cancel.png" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <input class="right" onclick="addPagamento()" type="button" value="add" />
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-8-12" style="margin-left: -4px">
                                        <label>Observa&ccedil;&atilde;o</label>
                                        <textarea id="observacao" name="observacao" id="" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="grid-4-12">
                                    <input id="idTitulo" type="hidden" name="idTitulo" value="" />
                                    <input class="left" type="button" onclick="salvar()" title="Salvar a <?php echo $action; ?>" value="Salvar" />
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
