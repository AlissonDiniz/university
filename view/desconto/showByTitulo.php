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
                $("#editButton").click(function() {
                    $("#editForm").submit();
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
                    <h1>Mostrar Desconto</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>listByTitulo/<? echo $data['dados']['titulo_id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee">
                        <?
                        if ($data['dados']['titulo_id'] != "") {
                            ?>
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
                            <label>
                                <span class="legenda">Nosso Número:</span>
                                <br />
                                <span class="texto"><? echo $data['dados']['nosso_numero']; ?></span>
                            </label>
                            <label>
                                <span class="legenda">Título:</span>
                                <br />
                                <a target="_blank" href="<?= application ?>titulo/show/<? echo $data['dados']['titulo']; ?>">
                                    <span class="texto">>> clique aqui</span>
                                </a>
                            </label>
                            <?
                        }
                        ?>
                        <label>
                            <span class="legenda">Parcela:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['parcela'] ?></span>
                        </label>
                        <label>
                            <span class="legenda">Valor:</span>
                            <br />
                            <span class="texto"><? echo $classFunction["number"]->formatMoney($data['dados']['valor']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Tipo do Desconto:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['tipoDesconto'] ?></span>
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
                        </div>
                        <form id="editForm" action="<?= $uri ?>editByTitulo" method="POST">
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
