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
                    <h1>Mostrar Título</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri; ?>create">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Baixar Título</span>
                            </a>
                            <a href="<?= $uri; ?>createGroup">
                                <img src="<?= image ?>icons/database_table.png" />
                                <span>Baixar Título - Agrupado</span>
                            </a>
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
                    <div class="conteudo formee">
                        <label>
                            <span class="legenda">Matricula do Aluno:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['matricula']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Nome do Aluno:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['nome']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Nosso Número:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['nosso_numero']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Título:</span>
                            <br />
                            <a target="_blank" href="<?= application ?>titulo/show/<? echo $data['dados']['titulo']; ?>">
                                <span class="texto">>> clique aqui</span>
                            </a>
                        </label>
                        <label>
                            <span class="legenda">Valor Pago:</span>
                            <br />
                            <span class="texto"><? echo $classFunction["number"]->formatMoney($data['dados']['valor_pago']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Forma de Pagamento:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['formaPagamento']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Data do Pagamento:</span>
                            <br />
                            <span class="texto"><? echo $classFunction["data"]->dataUSAToDataBrasil($data['dados']['data_pagamento']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Usuário Operador:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['userName']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Data da Operação:</span>
                            <br />
                            <span class="texto"><? echo $classFunction["data"]->dataUSAToDataHoraBrasil($data['dados']['data']); ?></span>
                        </label>
                        <?
                        if ($data['dados']['data_update'] != "") {
                            ?>
                            <label>
                                <span class="legenda">Usuário Operador da Alteração:</span>
                                <br />
                                <span class="texto"><? echo $data['dados']['userUpdate']; ?></span>
                            </label>
                            <label>
                                <span class="legenda">Data da Alteração:</span>
                                <br />
                                <span class="texto"><? echo $classFunction["data"]->dataUSAToDataHoraBrasil($data['dados']['data_update']); ?></span>
                            </label>
                            <?
                        }
                        ?>
                        <label>
                            <span class="legenda">Observação:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['observacao']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Agência:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['agencia']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Banco:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['banco']; ?></span>
                        </label>
                        <?
                        if ($data['dados']['arquivo_id'] != "") {
                            ?>
                            <label>
                                <span class="legenda">Arquivo:</span>
                                <br />
                                <a target="_blank" href="<?= application ?>arquivo/show/<? echo $data['dados']['arquivo_id']; ?>">
                                    <span class="texto">>> clique aqui</span>
                                </a>
                            </label>
                            <?
                        }
                        ?>
                        <label>
                            <span class="legenda">Retorno ID:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['id_retorno']; ?></span>
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
