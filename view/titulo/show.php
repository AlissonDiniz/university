<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#editButton").click(function() {
                    $("#editForm").submit();
                });
                $("#printButton").click(function() {
                    $("#printForm").submit();
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
                    <h1>Mostrar Título</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>create">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Cadastrar</span>
                            </a>
                            <a href="<?= $uri ?>list">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                            <a href="<?= $uri ?>search">
                                <img src="<?= image ?>icons/zoom.png" />
                                <span>Pesquisar</span>
                            </a>
                            <a href="<?= application ?>acrescimo/listByTitulo/<? echo $data['dados']['id']; ?>">
                                <img src="<?= image ?>icons/paper.png" />
                                <span>Acrescimos</span>
                            </a>
                            <a href="<?= application ?>desconto/listByTitulo/<? echo $data['dados']['id']; ?>">
                                <img src="<?= image ?>icons/paper-red.png" />
                                <span>Descontos</span>
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
                            <span class="texto"><? echo $data['dados']['matricula']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Nome do Aluno:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['nome']; ?></span>
                        </label>
                        <?
                        if ($data['dados']['parcela'] != "") {
                            ?>
                            <label>
                                <span class="legenda">Parcela:</span>
                                <br />
                                <a target="_blank" href="<?= application ?>parcela/show/<? echo $data['dados']['parcela']; ?>">
                                    <span class="texto">>> clique aqui</span>
                                </a>
                            </label>
                            <?
                        }
                        ?>
                        <label>
                            <span class="legenda">Nosso Número:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['nosso_numero']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Configuração Bancária:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['configuracao']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Valor:</span>
                            <br />
                            <span class="texto"><? echo $classFunction["number"]->formatMoney($data['dados']['valor']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Valor Restante:</span>
                            <br />
                            <span class="texto"><? echo $classFunction["number"]->formatMoney($data['dados']['valor_restante']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Valor Multa:</span>
                            <br />
                            <span class="texto"><? echo $classFunction["number"]->formatMoney($data['dados']['valor_multa']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Valor Juros:</span>
                            <br />
                            <span class="texto"><? echo $classFunction["number"]->formatMoney($data['dados']['valor_juros']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Valor Desconto:</span>
                            <br />
                            <span class="texto"><? echo $classFunction["number"]->formatMoney($data['dados']['valor_desconto']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Data de Vencimento:</span>
                            <br />
                            <span class="texto"><? echo $classFunction["data"]->dataUSAToDataBrasil($data['dados']['vencimento']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Linha Digitável:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['linha_digitavel']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Situação:</span>
                            <br />
                            <span class="texto"><? echo $classFunction["enum"]->enumOpcoes($data['dados']['situacao'], $classFunction["situacaoTitulo"]->loadOpcoes()); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Status:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumStatus($data['dados']['status']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Observa&ccedil;&atilde;o:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['observacao']; ?></span>
                        </label>
                        <div class="grid-4-12">
                            <input id="editButton" class="left" type="button" title="Editar a <?php echo $action; ?>" value="Editar" />
                            <input id="printButton" class="left" style="margin-left: 10px" type="button" title="Imprimir o Título" value="Imprimir" />
                        </div>
                        <form id="editForm" action="<?= $uri ?>edit" method="POST">
                            <input type="hidden" name="id" value="<? echo $data['dados']['id']; ?>" />
                        </form>
                        <form id="printForm" target="_blank" action="<?= application ?>boleto/reportByTitulo" method="POST">
                            <input type="hidden" name="id" value="<? echo $data['dados']['id']; ?>" />
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
