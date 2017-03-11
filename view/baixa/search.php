<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskMoney.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $('#valor').maskMoney();
                $("#dataPagamentoInit").mask("99/99/9999");
                $("#horaPagamentoInit").mask("99:99");
                $("#dataPagamentoEnd").mask("99/99/9999");
                $("#horaPagamentoEnd").mask("99:99");
                $("#dataOperacaoInit").mask("99/99/9999");
                $("#horaOperacaoInit").mask("99:99");
                $("#dataOperacaoEnd").mask("99/99/9999");
                $("#horaOperacaoEnd").mask("99:99");
                $("#nossoNumero").keypress(function(e) {
                    return verificaNumero(e);
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
                    <h1>Buscar Título</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri; ?>create">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Baixar Título</span>
                            </a>
                            <a href="<?= $uri; ?>createGroup">
                                <img src="<?= image ?>icons/database_table.png" />
                                <span>Baixar Título - Agrupado</span>
                            </a>
                            <a href="<?= $uri ?>list">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>result" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Nosso Número</label>
                                    <input id="nossoNumero" name="nossoNumero" type="text" value="" maxlength="11" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Matricula do Aluno</label>
                                    <input id="matricula" name="matricula" type="text" value="" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <label>Nome do Aluno</label>
                                <input id="nome" name="nome" type="text" value="" />
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Valor</label>
                                    <input id="valor" name="valor" type="text" value="" maxlength="7" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div style="width: 260px; float: left; margin-right: 20px">
                                    <div class="grid-10-12" style="margin-left: -4px">
                                        <label>Data de Pagamento Inicial</label>
                                        <input id="dataPagamentoInit" name="dataPagamentoInit" type="text" value="<? echo "01" . date("/m/Y"); ?>" maxlength="10" />
                                    </div>
                                </div>
                                <div style="width: 260px; float: left">
                                    <div class="grid-10-12" style="margin-left: -4px">
                                        <label>Data de Pagamento Final</label>
                                        <input id="dataPagamentoEnd" name="dataPagamentoEnd" type="text" value="<? echo date("d/m/Y"); ?>" maxlength="10" />
                                    </div>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Forma de Pagamento</label>
                                    <select id="formaPagamento" name="formaPagamento">
                                        <option value="%">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptions($data['formasPagamento']); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div style="width: 320px; float: left; margin-right: 40px">
                                    <div class="grid-8-12" style="margin-left: -4px">
                                        <label>Data da Operação Inicial</label>
                                        <input id="dataOperacaoInit" name="dataOperacaoInit" type="text" value="" maxlength="10" />
                                    </div>
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Hora Inicial</label>
                                        <input id="horaOperacaoInit" name="horaOperacaoInit" type="text" value="" maxlength="5" />
                                    </div>
                                </div>
                                <div style="width: 320px; float: left">
                                    <div class="grid-8-12" style="margin-left: -4px">
                                        <label>Data da Operação Final</label>
                                        <input id="dataOperacaoEnd" name="dataOperacaoEnd" type="text" value="" maxlength="10" />
                                    </div>
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Hora Final</label>
                                        <input id="horaOperacaoEnd" name="horaOperacaoEnd" type="text" value="" maxlength="5" />
                                    </div>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-6-12" style="margin-left: -4px">
                                    <label>Usuário</label>
                                    <select id="usuario" name="usuario">
                                        <option value="%">Todos</option>
                                        <? $classFunction['funcoesHTML']->createOptions($data['usuarios']); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-4-12">
                                <input class="left" type="submit" title="Buscar a <?php echo $action; ?>" value="Buscar" />
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
