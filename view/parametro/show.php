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
                    <h1>Mostrar Parametros</h1>
                    <div class="submenus">
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-top: -10px">
                        <label>
                            <span class="legenda">Período Atual:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['periodoAtual']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Período Matricula:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['periodoMatricula']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Valor da Taxa do Boleto:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['number']->formatMoney($data['dados']['taxa_boleto']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Dias Úteis para Atrazo:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['dias_para_atrazo']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Taxa da Multa %:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['number']->formatCurrency($data['dados']['taxa_multa']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Taxa da Mora %:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['number']->formatCurrency($data['dados']['taxa_mora']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Mensagens:</span>
                            <br />
                            <span class="texto"><? echo str_replace("\r\n", "<br />", $data['dados']['mensagens']); ?></span>
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
