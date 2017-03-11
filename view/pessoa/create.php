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
        <script type="text/javascript" src="<?= js ?>pessoa/init.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <script type="text/javascript">
            var urlImage = "<?= profile . "?id=" . base64_encode($data['dados']['cpf']) ?>&1";
        </script>
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
                    <h1>Criar Pessoa</h1>
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
                    <div class="conteudo formee" style="margin: 20px 0 0 10px; width: 100%">
                        <label class="foto">
                            <img alt="" title="Foto" src="" /> 
                            <a href="#" onclick="alterarFoto()">Criar Foto</a>
                        </label>
                    </div>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>SAVE" method="POST">
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>CPF/CNPJ:<em class="formee-req">*</em></label>
                                    <input id="cpf" name="cpf" class="validate[required,funcCall[validarCPF]] text-input" type="text" value="" maxlength="14" />
                                    <input id="cnpj" style="display: none" name="cnpj" class="validate[required,funcCall[validarCNPJ]] text-input" type="text" value="0" maxlength="18" />
                                </div>
                                <div class="grid-12-12" style="text-align: left">
                                    <a id="typePessoa" href="#" title="Mudar o tipo de Pessoa">Pessoa Jurídica</a>
                                </div>
                            </div>
                            <div class="grid-10-12">
                                <label>Nome:<em class="formee-req">*</em></label>
                                <input id="nome" name="nome" class="validate[required] text-input" type="text" value="" />
                            </div>
                            <div id="dadosPessoais">
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Sexo<em class="formee-req">*</em></label>
                                        <select id="sexo" name="sexo">
                                            <option value="M">Masculino</option>
                                            <option value="F">Feminino</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Data de Nascimento:<em class="formee-req">*</em></label>
                                        <input id="dataNascimento" name="dataNascimento" class="validate[required] text-input" type="text" value="" maxlength="10" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Estado Civil<em class="formee-req">*</em></label>
                                        <select id="estadoCivil" name="estadoCivil">
                                            <? $classFunction['funcoesHTML']->createOptions($classFunction['estadoCivil']->loadOpcoes()) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-3-12" style="margin-left: -4px; margin-right: 20px; width: 150px">
                                        <label>Nº Identidade:<em class="formee-req">*</em></label>
                                        <input id="identidade" name="identidade" class="validate[required] text-input" type="text" value="" />
                                    </div>
                                    <div class="grid-3-12" style="margin-left: -4px">
                                        <label>Orgão Emissor:</label>
                                        <input id="orgaoEmissorIdentidade" name="orgaoEmissorIdentidade" type="text" value="" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-5-12" style="margin-left: -4px">
                                        <label>Estado da Identidade:</label>
                                        <select id="estadoIdentidade" name="estadoIdentidade">
                                            <? $classFunction['funcoesHTML']->createOptions($classFunction['estados']->loadEstados()) ?>
                                        </select>
                                    </div>
                                    <div class="grid-3-12" style="margin-left: -4px">
                                        <label>Data de Expedição:</label>
                                        <input id="dataIdentidade" name="dataIdentidade" type="text" value="" maxlength="10" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-3-12" style="margin-left: -4px; margin-right: 20px; width: 150px">
                                        <label>Nº Título Eleitoral:</label>
                                        <input id="tituloEleitoral" name="tituloEleitoral" type="text" value="" />
                                    </div>
                                    <div class="grid-3-12" style="margin-left: -4px">
                                        <label>Zona:</label>
                                        <input id="zona" name="zona" type="text" value="" />
                                    </div>
                                    <div class="grid-3-12" style="margin-left: -4px">
                                        <label>Seção:</label>
                                        <input id="secao" name="secao" type="text" value="" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>PIS / PASEP:</label>
                                        <input id="pispasep" name="pispasep" type="text" value="" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-8-12" style="margin-left: -4px">
                                        <label>Naturalidade:<em class="formee-req">*</em></label>
                                        <input id="naturalidade" name="naturalidade" class="validate[required] text-input" type="text" value="" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-8-12" style="margin-left: -4px">
                                        <label>Nacionalidade:</label>
                                        <input id="nacionalidade" name="nacionalidade" class="validate[required] text-input" type="text" value="BRASILEIRO" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-10-12" style="margin-left: -4px">
                                        <label>Nome Pai:</label>
                                        <input id="nomePai" name="nomePai" type="text" value="" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>CPF Pai:</label>
                                        <input id="cpfPai" name="cpfPai" type="text" value="" maxlength="14" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-10-12" style="margin-left: -4px">
                                        <label>Nome Mãe:</label>
                                        <input id="nomeMae" name="nomeMae" type="text" value="" />
                                    </div>
                                </div>
                                <div class="grid-12-12">
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>CPF Mãe:</label>
                                        <input id="cpfMae" name="cpfMae" type="text" value="" maxlength="14" />
                                    </div>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>CEP:<em class="formee-req">*</em></label>
                                    <input id="cep" name="cep" class="validate[required] text-input" type="text" value="" maxlength="9" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-10-12" style="margin-left: -4px">
                                    <label>Logradouro:<em class="formee-req">*</em></label>
                                    <input id="logradouro" name="logradouro" class="validate[required] text-input" type="text" value="" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-3-12" style="margin-left: -4px">
                                    <label>Número:<em class="formee-req">*</em></label>
                                    <input id="numero" name="numero" class="validate[required] text-input" type="text" value="" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Complemento:</label>
                                    <input id="complemento" name="complemento" type="text" value="" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Bairro:<em class="formee-req">*</em></label>
                                    <input id="bairro" name="bairro" class="validate[required] text-input" type="text" value="" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>Cidade:<em class="formee-req">*</em></label>
                                    <input id="cidade" name="cidade" class="validate[required] text-input" type="text" value="" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-5-12" style="margin-left: -4px">
                                    <label>Estado:</label>
                                    <select id="estado" name="estado">
                                        <? $classFunction['funcoesHTML']->createOptions($classFunction['estados']->loadEstados()) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Telefone 1:<em class="formee-req">*</em></label>
                                    <input id="telefone1" name="telefone1" class="validate[required] text-input" type="text" value="" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-4-12" style="margin-left: -4px">
                                    <label>Telefone 2:</label>
                                    <input id="telefone2" name="telefone2" type="text" value="" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-8-12" style="margin-left: -4px">
                                    <label>E-mail:<em class="formee-req">*</em></label>
                                    <input id="email" name="email" class="validate[required] text-input" type="text" value="" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-10-12" style="margin-left: -4px">
                                    <label>Formação:</label>
                                    <input id="formacao" name="formacao" type="text" value="" />
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-10-12" style="margin-left: -4px">
                                    <label>Ocupação:</label>
                                    <input id="ocupacao" name="ocupacao" type="text" value="" />
                                </div>
                            </div>
                            <div id="dadosOutros">
                                <div class="grid-12-12">
                                    <div class="grid-3-12" style="margin-left: -4px; margin-right: 100px">
                                        <label>Canhoto:<em class="formee-req">*</em></label>
                                        <select id="canhoto" name="canhoto">
                                            <option value="N">Não</option>
                                            <option value="S">Sim</option>
                                        </select>
                                    </div>
                                    <div class="grid-4-12" style="margin-left: -4px">
                                        <label>Deficiência:<em class="formee-req">*</em></label>
                                        <select id="deficiencia" name="deficiencia">
                                            <? $classFunction['funcoesHTML']->createOptions($classFunction['deficiencia']->loadOpcoes()) ?>
                                        </select>
                                    </div>
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
        <div title="Alterar a Foto" id="alterarFotoFrame" style="display: none">
            <iframe src="<?= service ?>webcam/image/<? echo $data['dados']['cpf'] ?>" width="570" height="380" frameborder="no">
            </iframe>
        </div>
    </body>
</html>
