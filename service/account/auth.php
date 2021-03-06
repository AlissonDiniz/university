<?
include_once '../config/urlmapping.php';
?>
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
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine-pt.js"></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(function(){
                $("#username").focus();
                jQuery("#form").validationEngine();
            });
        </script>
    </head>
    <body>
        <div id="wrapper">
            <div id="barraNavegacao"></div>
            <div id="content">
                <div id="boxCentral">
                    <div class="logoTexto">
                        <h1><?php echo name; ?></h1>
                        <span class="tipo">Acadêmico</span>
                        <span>Release <? echo release; ?></span>
                    </div>
                    <div class="login formee">
                        <form id="form" action="<? echo $uri; ?>logon" method="POST">
                            <div class="grid-12-12" style="margin-bottom: 15px">
                                <label>Login <em class="formee-req">*</em></label>
                                <input id="username" name="username" class="validate[required] text-input" type="text" value="" />
                            </div>
                            <div class="grid-12-12 clear">
                                <label>Password <em class="formee-req">*</em></label>
                                <input id="password" name="password" class="validate[required] text-input" type="password" value="" />
                            </div>
                            <div class="grid-6-12 clear">
                                <h1 class="login_message"><? echo $data; ?></h1>
                            </div>      
                            <div class="grid-6-12">
                                <input class="right" type="submit" title="Acessar o Sistema" value="Acessar" />
                            </div>
                        </form>
                    </div>
                </div>
                <div id="footer">
                    <p>&copy; Desenvolvido por <a href="http://about.me/alissondiniz" target="_blank" style="color: #333333; font-weight: bold">Alisson Diniz</a></p>
                    <p style="float: right; margin-right: 0"><a href="<? echo pathHttp ?>portalaluno" target="_blank" style="color: #0000FF; text-decoration: underline">Portal do Aluno</a></p>
                    <p style="float: right; margin-right: 40px"><a href="<? echo pathHttp ?>portalprofessor" target="_blank" style="color: #0000FF; text-decoration: underline">Portal do Professor</a></p>
                </div>
            </div>
        </div>
    </body>
</html>
