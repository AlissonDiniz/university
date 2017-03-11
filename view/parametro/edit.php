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
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskMoney.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine-pt.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $('#taxaBoleto').maskMoney();
                $('#diasAtrazo').keypress(verificaNumero);
                $('#taxaMulta').maskMoney();
                $('#taxaMora').maskMoney();
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
                    <h1>Editar Parametros</h1>
                    <div class="submenus">
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee" style="margin-top: -10px">
                        <form id="form" action="<?= $uri ?>UPDATE" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Período Atual<em class="formee-req">*</em></label>
                                    <select id="periodoAtual" name="periodoAtual">
                                        <? $classFunction['funcoesHTML']->createOptionsValidate($data['parametros']['dados']['periodo_atual_id'], $data['periodos']) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Período Matricula<em class="formee-req">*</em></label>
                                    <select id="periodoMatricula" name="periodoMatricula">
                                        <? $classFunction['funcoesHTML']->createOptionsValidate($data['parametros']['dados']['periodo_matricula_id'], $data['periodos']) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Valor da Taxa do Boleto</label>
                                    <input id="taxaBoleto" name="taxaBoleto" type="text" value="<? echo $classFunction['number']->formatCurrency($data['parametros']['dados']['taxa_boleto']); ?>" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <label>Dias Úteis para Atrazo</label>
                                <input id="diasAtrazo" name="diasAtrazo" style="float: left; width: 50px" type="text" value="<? echo $data['parametros']['dados']['dias_para_atrazo']; ?>" maxlength="2" />
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Taxa da Mora %</label>
                                    <input id="taxaMora" name="taxaMora" type="text" value="<? echo $classFunction['number']->formatCurrency($data['parametros']['dados']['taxa_mora']); ?>" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Taxa da Multa %</label>
                                    <input id="taxaMulta" name="taxaMulta" type="text" value="<? echo $classFunction['number']->formatCurrency($data['parametros']['dados']['taxa_multa']); ?>" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Mensagens</label>
                                    <textarea id="mensagens" name="mensagens" id="" cols="30" rows="10"><? echo $data['parametros']['dados']['mensagens']; ?></textarea>
                                </div>
                            </div>
                            <div class="grid-4-12">
                                <input class="left" type="submit" title="Salvar a <?php echo $action; ?>" value="Salvar" />
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
