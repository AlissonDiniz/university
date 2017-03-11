<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "/create.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
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
                    <h1>Buscar Usuário</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>create">
                                <img src="<?= image ?>icons/zoom.png" />
                                <span>Cadastrar</span>
                            </a>
                            <a href="<?= $uri ?>list">
                                <img src="<?= image ?>icons/database_refresh.png" />
                                <span>Listar</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>result" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-6-12" style="margin-left: -4px">
                                    <label>Login<em class="formee-req">*</em></label>
                                    <input id="username" name="username" type="text" value="" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <label>Nome<em class="formee-req">*</em></label>
                                <input id="nome" name="nome" type="text" value="" />
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Status<em class="formee-req">*</em></label>
                                    <select id="status" name="status">
                                        <option value="%">Todos</option>
                                        <option value="1">Ativo</option>
                                        <option value="0">Inativo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Grupo de regras<em class="formee-req">*</em></label>
                                    <select id="status" name="role">
                                        <option value="%">Todos</option>
                                        <?
                                        foreach ($data as $line) {
                                            ?>
                                            <option value="<? echo $line['dados']['id']; ?>"><? echo $line['dados']['descricao']; ?></option>
                                            <?
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-4-12">
                                <input class="left" type="submit" title="Buscar a <?php echo $action; ?>" value="Buscar" />
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
