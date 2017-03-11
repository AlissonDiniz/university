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
                    <h1>Mostrar Parcela</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>list?plano=<? echo $data['dados']['plano_id']; ?>">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                            <a href="<?= $uri; ?>create?plano=<? echo $data['dados']['plano_id']; ?>">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Cadastrar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-bottom: 20px">
                        <label style="width: 60px">
                            <span class="legenda">Período:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['periodo']; ?></span>
                        </label>
                        <label style="width: 350px">
                            <span class="legenda">Curso:</span>
                            <br />
                            <span class="texto"><? echo substr($data['dados']['curso'], 0, 40); ?>...</span>
                        </label>
                        <label style="width: 280px">
                            <span class="legenda">Descrição:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['descricao']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Número Parcela:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['numero']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Mês de Referência:</span>
                            <br />
                            <span class="texto"><? echo $classFunction["enum"]->enumOpcoes($data['dados']['mes'], $classFunction["meses"]->loadOpcoes()); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Valor:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['number']->formatMoney($data['dados']['valor']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Data de Vencimento:</span>
                            <br />
                            <span class="texto"><? echo $classFunction["data"]->dataUSAToDataBrasil($data['dados']['data_vencimento']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Observa&ccedil;&atilde;o:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['observacao']; ?></span>
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
