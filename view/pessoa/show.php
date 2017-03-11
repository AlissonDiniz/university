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
            $(document).ready(function(){
                $("#editButton").click(function(){
                    $("#editForm").submit();
                });
                <?
                if (strlen($data['dados']['cpf']) > 14) {
                    echo '$("#dadosPessoais").hide();';
                    echo '$("#dadosOutros").hide();';
                } else {
                    echo '$("#cpf").mask("999.999.999-99");';
                }
                ?>
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
                    <h1>Mostrar Pessoa</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= $uri ?>create">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Cadastrar</span>
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
                            <img alt="" src="<?= profile . "?id=" . base64_encode($data['dados']['cpf']) ?>" width="100" height="120" />
                        </label>
                        <label>
                            <span class="legenda">CPF/CNPJ:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['cpf']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Nome:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['nome']; ?></span>
                        </label>
                        <div id="dadosPessoais">
                            <label>
                                <span class="legenda">Sexo:</span>
                                <br />
                                <span class="texto"><? echo $classFunction['enum']->enumSexo($data['dados']['sexo']); ?></span>
                            </label>
                            <label>
                                <span class="legenda">Data de Nascimento:</span>
                                <br />
                                <span class="texto"><? echo $classFunction['data']->dataUSAToDataBrasil($data['dados']['data_nascimento']); ?></span>
                            </label>
                            <label>
                                <span class="legenda">Estado Civil:</span>
                                <br />
                                <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['dados']['estado_civil'], $classFunction['estadoCivil']->loadOpcoes()); ?></span>
                            </label>
                            <label>
                                <span class="legenda">N° Identidade:</span>
                                <br />
                                <span class="texto"><? echo $data['dados']['identidade']; ?></span>
                            </label>
                            <label>
                                <span class="legenda">Órgão Emissor Identidade:</span>
                                <br />
                                <span class="texto"><? echo $data['dados']['orgao_emissor_identidade']; ?></span>
                            </label>
                            <label>
                                <span class="legenda">Estado Identidade:</span>
                                <br />
                                <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['dados']['estado_identidade'], $classFunction['estados']->loadEstados()); ?></span>
                            </label>
                            <label>
                                <span class="legenda">Data de Expedição:</span>
                                <br />
                                <span class="texto"><? echo $classFunction['data']->dataUSAToDataBrasil($data['dados']['data_identidade']); ?></span>
                            </label>
                            <label>
                                <span class="legenda">Título Eleitoral:</span>
                                <br />
                                <span class="texto"><? echo $data['dados']['titulo_eleitoral']; ?></span>
                            </label>
                            <label>
                                <span class="legenda">Zona:</span>
                                <br />
                                <span class="texto"><? echo $data['dados']['zona']; ?></span>
                            </label>
                            <label>
                                <span class="legenda">Secão:</span>
                                <br />
                                <span class="texto"><? echo $data['dados']['secao']; ?></span>
                            </label>
                            <label>
                                <span class="legenda">PIS / PASEP:</span>
                                <br />
                                <span class="texto"><? echo $data['dados']['pispasep']; ?></span>
                            </label>
                            <label>
                                <span class="legenda">Naturalidade:</span>
                                <br />
                                <span class="texto"><? echo $data['dados']['naturalidade']; ?></span>
                            </label>
                            <label>
                                <span class="legenda">Nacionalidade:</span>
                                <br />
                                <span class="texto"><? echo $data['dados']['nacionalidade']; ?></span>
                            </label>
                            <label>
                                <span class="legenda">Nome do Pai:</span>
                                <br />
                                <span class="texto"><? echo $data['dados']['nome_pai']; ?></span>
                            </label>
                            <label>
                                <span class="legenda">CPF do Pai:</span>
                                <br />
                                <span class="texto"><? echo $data['dados']['cpf_pai']; ?></span>
                            </label>
                            <label>
                                <span class="legenda">Nome da Mãe:</span>
                                <br />
                                <span class="texto"><? echo $data['dados']['nome_mae']; ?></span>
                            </label>
                            <label>
                                <span class="legenda">CPF da Mãe:</span>
                                <br />
                                <span class="texto"><? echo $data['dados']['cpf_mae']; ?></span>
                            </label>
                        </div>
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
                        <label>
                            <span class="legenda">Formação:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['formacao']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Ocupação:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['ocupacao']; ?></span>
                        </label>
                        <div id="dadosOutros">
                            <label>
                                <span class="legenda">Canhoto:</span>
                                <br />
                                <span class="texto"><? echo $classFunction['enum']->enumCanhoto($data['dados']['canhoto']); ?></span>
                            </label>
                            <label>
                                <span class="legenda">Deficiência:</span>
                                <br />
                                <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['dados']['deficiente'], $classFunction['deficiencia']->loadOpcoes()); ?></span>
                            </label>
                        </div>
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
