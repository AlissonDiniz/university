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
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            function processar() {
                if ($("#file").val() != "") {
                    if (($("#file").val()).indexOf(".TXT") != -1 || ($("#file").val()).indexOf(".txt") != -1) {
                        $("#form").submit();
                    } else {
                        alert("O Arquivo deve ser do tipo .txt!");
                    }
                } else {
                    alert("Escolha um arquivo de remessa!");
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
                    <h1>Visualizar dados do Arquivo de Remessa</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>listRemessa">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                            <a href="<?= $uri; ?>searchRemessa">
                                <img src="<?= image ?>icons/zoom.png" />
                                <span>Pesquisar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>reportRemessa" method="POST" enctype="multipart/form-data">
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin: -2px 0 0 -4px">
                                    <label>Arquivo de Remessa</label>
                                    <input id="file" name="file" type="file" value="" />
                                </div>
                            </div>
                            <div class="grid-4-12" style="margin-left: 5px">
                                <input class="left" type="button" onclick="processar()" title="Visualizar os dados do Arquivo" value="Visualizar" />
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
