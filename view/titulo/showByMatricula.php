<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            $(document).ready(function() {
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
                    <h1>Mostrar Título do Aluno</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>listByMatricula?m=<? echo $data['dados']['matricula_id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
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
                            <input id="printButton" class="left" type="button" title="Imprimir o Título" value="Imprimir" />
                        </div>
                    </div>
                </div>
                <form id="printForm" target="_blank" action="<?= application ?>boleto/reportByTitulo" method="POST">
                    <input type="hidden" name="id" value="<? echo $data['dados']['id']; ?>" />
                </form>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
    </body>
</html>
