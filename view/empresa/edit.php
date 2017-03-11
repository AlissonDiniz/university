<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>validationEngine/css/jquery.validationEngine.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>jquery-ui-1.9.2.custom/css/start/jquery-ui-1.9.2.custom.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= js ?>jquery/validators.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine-pt.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $("#cnpj").mask("99.999.999/9999-99");
                $("#cep").mask("99999-999");
                $("#telefone1").mask("(99) 9999-9999");
                $("#telefone2").mask("(99) 9999-9999");
                jQuery("#form").validationEngine();
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
                    <h1>Editar Empresa</h1>
                    <div class="submenus">
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee" style="margin-top: -10px">
                        <form id="form" action="<?= $uri ?>UPDATE" method="POST">
                            <div class="grid-6-12">
                                <label>CNPJ:<em class="formee-req">*</em></label>
                                <input id="cnpj" name="cnpj" class="validate[required,funcCall[validarCNPJ]] text-input" type="text" value="<? echo $data['dados']['cnpj']; ?>" maxlength="18" />
                            </div>
                            <div class="grid-10-12">
                                <label>Razão Social:<em class="formee-req">*</em></label>
                                <input id="razao" name="razao" class="validate[required] text-input" type="text" value="<? echo $data['dados']['razao']; ?>" />
                            </div>
                            <div class="grid-10-12">
                                <label>Nome Fantasia:<em class="formee-req">*</em></label>
                                <input id="nome" name="nome" class="validate[required] text-input" type="text" value="<? echo $data['dados']['nome']; ?>" />
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>CEP:<em class="formee-req">*</em></label>
                                    <input id="cep" name="cep" class="validate[required] text-input" type="text" value="<? echo $data['dados']['cep']; ?>" maxlength="9" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-10-12" style="margin-left: -4px">
                                    <label>Logradouro:<em class="formee-req">*</em></label>
                                    <input id="logradouro" name="logradouro" class="validate[required] text-input" type="text" value="<? echo $data['dados']['logradouro']; ?>" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Número:<em class="formee-req">*</em></label>
                                    <input id="numero" name="numero" class="validate[required] text-input" type="text" value="<? echo $data['dados']['numero']; ?>" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Complemento:</label>
                                    <input id="complemento" name="complemento" type="text" value="<? echo $data['dados']['complemento']; ?>" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Bairro:<em class="formee-req">*</em></label>
                                    <input id="bairro" name="bairro" class="validate[required] text-input" type="text" value="<? echo $data['dados']['bairro']; ?>" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Cidade:<em class="formee-req">*</em></label>
                                    <input id="cidade" name="cidade" class="validate[required] text-input" type="text" value="<? echo $data['dados']['cidade']; ?>" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-5-12" style="margin-left: -4px">
                                    <label>Estado:</label>
                                    <select id="estado" name="estado">
                                        <? $classFunction['funcoesHTML']->createOptionsValidate($data['dados']['estado'], $classFunction['estados']->loadEstados()) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Telefone 1:<em class="formee-req">*</em></label>
                                    <input id="telefone1" name="telefone1" class="validate[required] text-input" type="text" value="<? echo $data['dados']['telefone1']; ?>" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Telefone 2:</label>
                                    <input id="telefone2" name="telefone2" type="text" value="<? echo $data['dados']['telefone2']; ?>" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>E-mail:<em class="formee-req">*</em></label>
                                    <input id="email" name="email" class="validate[required] text-input" type="text" value="<? echo $data['dados']['email']; ?>" />
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
