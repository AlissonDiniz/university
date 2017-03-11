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
                    <h1>Mostrar Empresa</h1>
                    <div class="submenus">
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-top: -10px">
                         <label>
                            <span class="legenda">CNPJ:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['cnpj']; ?></span>
                        </label>
                         <label>
                            <span class="legenda">Razão Social:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['razao']; ?></span>
                        </label>
                         <label>
                            <span class="legenda">Nome Fantasia:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['nome']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">CEP:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['cep']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Logradouro:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['logradouro']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Número:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['numero']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Complemento:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['complemento']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Bairro:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['bairro']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Cidade:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['cidade']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Estado:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['dados']['estado'], $classFunction['estados']->loadEstados()); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Telefone 1:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['telefone1']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Telefone 2:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['telefone2']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">E-mail:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['email']; ?></span>
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
