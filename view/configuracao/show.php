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
                    <h1>Mostrar Configuração Bancária</h1>
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
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee">
                        <label>
                            <span class="legenda">Banco:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['banco']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Nome do Banco:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['nome_banco']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Agência:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['agencia']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Conta Corrente:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['conta']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Código do Cliente:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['codigo_cliente']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Código da Remessa:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['codigo_remessa']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Carteira:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['carteira']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Convênio:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['convenio']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Operação:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['operacao']; ?></span>
                        </label>
                        <div class="grid-4-12">
                            <input id="editButton" class="left" type="button" title="Editar a <?php echo $action; ?>" value="Editar" />
                        </div>
                        <form id="editForm" action="<?= $uri ?>edit" method="POST">
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
