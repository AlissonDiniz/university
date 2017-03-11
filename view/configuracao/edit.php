<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>validationEngine/css/jquery.validationEngine.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine-pt.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                $("#deleteButton").click(function(){
                    if(confirm("Tem certeza que deseja deletar?")){
                        $("#deleteForm").submit();
                    }
                });
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
                    <h1>Editar Configuração Bancária</h1>
                    <div class="submenus">
                        <p>
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
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>UPDATE" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Banco<em class="formee-req">*</em></label>
                                    <input id="banco" name="banco" class="validate[required] text-input" type="text" value="<? echo $data['dados']['banco']; ?>" maxlength="4" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <label>Nome do Banco<em class="formee-req">*</em></label>
                                <input id="nomeBanco" name="nomeBanco" class="validate[required] text-input" type="text" value="<? echo $data['dados']['nome_banco']; ?>" />
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Agência<em class="formee-req">*</em></label>
                                    <input id="agencia" name="agencia" class="validate[required] text-input" type="text" value="<? echo $data['dados']['agencia']; ?>" maxlength="6" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Conta Corrente<em class="formee-req">*</em></label>
                                    <input id="conta" name="conta" class="validate[required] text-input" type="text" value="<? echo $data['dados']['conta']; ?>" maxlength="11" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Código do Cliente<em class="formee-req">*</em></label>
                                    <input id="codigoCliente" name="codigoCliente" class="validate[required] text-input" type="text" value="<? echo $data['dados']['codigo_cliente']; ?>" maxlength="7" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Código da Remessa<em class="formee-req">*</em></label>
                                    <input id="codigoRemessa" name="codigoRemessa" class="validate[required] text-input" type="text" value="<? echo $data['dados']['codigo_remessa']; ?>" maxlength="15" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Carteira<em class="formee-req">*</em></label>
                                    <input id="carteira" name="carteira" class="validate[required] text-input" type="text" value="<? echo $data['dados']['carteira']; ?>" maxlength="3" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Convênio<em class="formee-req">*</em></label>
                                    <input id="convenio" name="convenio" class="validate[required] text-input" type="text" value="<? echo $data['dados']['convenio']; ?>" maxlength="2" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Operação<em class="formee-req">*</em></label>
                                    <input id="operacao" name="operacao" class="validate[required] text-input" type="text" value="<? echo $data['dados']['operacao']; ?>" maxlength="2" />
                                </div>
                            </div>
                            <div class="grid-4-12">
                                <input type="hidden" name="id" value="<? echo $data['dados']['id']; ?>" />
                                <input id="deleteButton" class="left" type="button" title="Deletar a <?php echo $action; ?>" value="Deletar" />
                                <input class="left" type="submit" title="Salvar a <?php echo $action; ?>" value="Salvar" />
                            </div>
                        </form>
                        <form id="deleteForm" action="<?php echo $uri . "DELETE"; ?>" method="POST">
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
