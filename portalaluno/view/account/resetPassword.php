<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= css ?>auth.css" />
        <link href='http://fonts.googleapis.com/css?family=Quando' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>validationEngine/css/jquery.validationEngine.css" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>jquery/jquery.maskedinput-1.2.2.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine-pt.js"></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $("#cpf").mask("999.999.999-99");
                $("#dataNascimento").mask("99/99/9999");
                $("#matricula").keypress(verificaNumero);
                jQuery("#form").validationEngine();
            });

            function validateData() {
                $.ajax
                        ({
                            type: "POST",
                            url: "<? echo application ?>account/validate/",
                            data: "cpf=" + $("#cpf").val() + "&ra=" + $("#matricula").val() + "&dt=" + $("#dataNascimento").val(),
                            cache: false,
                            success: function(data)
                            {
                                var object = jQuery.parseJSON(data);
                                if (object.status) {
                                    $("#cpf").attr("disabled", true);
                                    $("#dataNascimento").attr("disabled", true);
                                    $("#matricula").attr("disabled", true);
                                    $("#idAluno").val(object.id);
                                    $("#validar").hide();
                                    $("#divSenha").show();
                                } else {
                                    alert("Dados Inválidos!");
                                }
                            }
                        });
            }
        </script>
        <style type="text/css">
            .formee-msg-success{
                float: left; width: 350px;
            }
            .formee-msg-error{
                float: left; width: 350px;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <div id="barraNavegacao"></div>
            <div id="content">
                <div id="boxCentral" style="width: 100%;">
                    <div class="logoTexto" style="height: 300px">
                        <h1 style="font-size: 40px"><? echo name; ?></h1>
                        <span>Release <? echo release; ?></span>
                    </div>
                    <div class="formulario formee" style="float: left; width: 500px; padding: 15px 15px 15px 50px">
                        <h1 style="text-align: left">Recuperar / Cadastrar a Senha</h1>
                        <form id="form" action="<?= $uri ?>RESETSENHA" method="POST" style="margin-top: 30px">
                            <div>
                                <div class="grid-10-12">
                                    <label>CPF:<em class="formee-req">*</em></label>
                                    <input id="cpf" name="cpf" class="validate[required,funcCall[validarCPF]] text-input" type="text" value="" maxlength="14" />
                                </div>
                                <div class="grid-7-12">
                                    <label>Matricula:<em class="formee-req">*</em></label>
                                    <input id="matricula" name="matricula" type="text" value="" maxlength="10" />
                                </div>
                                <div class="grid-7-12">
                                    <label>Data de Nascimento:<em class="formee-req">*</em></label>
                                    <input id="dataNascimento" name="dataNascimento" class="validate[required] text-input" type="text" value="" maxlength="10" />
                                </div>
                                <div class="grid-3-12" style="margin: 30px 0 0 5px">
                                    <input id="validar" class="right" type="button" onclick="validateData()" title="Validar Dados pessoais" value="Validar" />
                                </div>
                            </div>
                            <div id="divSenha" style="display: none">
                                <div class="grid-9-12">
                                    <label>Senha<em class="formee-req">*</em></label>
                                    <input id="password" name="password" class="validate[required] text-input" type="password" value="" />
                                </div>
                                <div class="grid-9-12">
                                    <label>Confirme a senha<em class="formee-req">*</em></label>
                                    <input id="confirm_password" name="confirm_password" class="validate[required,equals[password]] text-input" type="password" value="" />
                                </div>
                                <div class="grid-10-12" style="margin-top: 20px">
                                    <input id="idAluno" type="hidden" name="id" value="<? echo $data['id']; ?>" />
                                    <input class="right" type="submit" title="Recuperar / Cadastrar a Senha" value="Recuperar" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div style="float: left; margin: 20px 0 0 420px">
                        <?php
                        include_once '../view/layout/main.php';
                        ?>
                    </div>
                </div>
                <div id="footer">
                    <p>&copy; Desenvolvido por <a href="http://about.me/alissondiniz" target="_blank" style="color: #333333; font-weight: bold">Alisson Diniz</a></p>
                    <p style="float: right; margin-right: 0"><a href="<? echo $uri ?>auth" style="color: #0000FF; text-decoration: underline">Entrar no sistema</a></p>
                </div>
            </div>
        </div>
    </body>
</html>
