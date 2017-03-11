<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>wysiwyg/jquery.wysiwyg.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>validationEngine/css/jquery.validationEngine.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>wysiwyg/jquery.wysiwyg.js"></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?= plugin ?>validationEngine/js/jquery.validationEngine-pt.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $("#deleteButton").click(function() {
                    if (confirm("Tem certeza que deseja deletar?")) {
                        $("#deleteForm").submit();
                    }
                });
                jQuery("#form").validationEngine();
                $('#alunoData').click(function() {
                    $('#divAlunoData').toggle();
                });
                $('#alunoAdress').click(function() {
                    $('#divAlunoAdress').toggle();
                });
                $('#alunoContact').click(function() {
                    $('#divAlunoContact').toggle();
                });
                $('#alunoAcademic').click(function() {
                    $('#divAlunoAcademic').toggle();
                });
                $('#textAreaValue').wysiwyg();
            });
        </script>
        <style type="text/css">
            .divContent{
                margin-bottom: 10px;
            }

            .divData{
                float: left;
                text-align: left;
                width: 700px; 
                padding: 20px;
                display: none;
            }
        </style>
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
                    <h1>Editar Relatório</h1>
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
                    <div class="conteudo formee">
                        <label>
                            <span class="legenda">Variáveis Disponíveis:</span>
                            <br />
                            <br />
                            <div class="divContent">
                                <span id="alunoData" class="texto" style="cursor: pointer">>> Dados Pessoais do Aluno</span>
                                <div id="divAlunoData" class="divData">
                                    <span>#{documentNumber} - Número do Documento</span>
                                    <br />
                                    <span>#{studentID} - Matricula do aluno</span>
                                    <br />
                                    <span>#{studentName} - Nome do aluno</span>
                                    <br />
                                    <span>#{studentSex} - Sexo do aluno</span>
                                    <br />
                                    <span>#{studentMaritalStatus} - Estado Civil do aluno</span>
                                    <br />
                                    <span>#{studentCPF} - CPF do aluno</span>
                                    <br />
                                    <span>#{studentRG} - RG do aluno</span>
                                    <br />
                                    <span>#{studentPIS} - PIS/PASEP do aluno</span>
                                    <br />
                                    <span>#{studentORG} - Órgão Emissor do RG do aluno</span>
                                    <br />
                                    <span>#{studentNationalityState} - Naturalidade do aluno</span>
                                    <br />
                                    <span>#{studentNationalityCountry} - Nacionalidade do aluno</span>
                                    <br />
                                    <span>#{studentFormation} - Formação do aluno</span>
                                    <br />
                                    <span>#{studentOccupation} - Ocupação do aluno</span>
                                    <br />
                                </div>
                            </div>
                            <div class="divContent">
                                <span id="alunoAdress" class="texto" style="cursor: pointer">>> Dados de Endereço do Aluno</span>
                                <div id="divAlunoAdress" class="divData">
                                    <span>#{studentCEP}: CEP do aluno</span>
                                    <br />
                                    <span>#{studentStreet}: Logradouro do aluno</span>
                                    <br />
                                    <span>#{studentNumber}: Número da Casa ou Apto do aluno</span>
                                    <br />
                                    <span>#{studentComplement}: Complemento do endereço do aluno</span>
                                    <br />
                                    <span>#{studentNeighborhood}: Bairro do aluno</span>
                                    <br />
                                    <span>#{studentCity}: Cidade do aluno</span>
                                    <br />
                                    <span>#{studentState}: Estado do aluno</span>
                                </div>
                            </div>
                            <div class="divContent">
                                <span id="alunoContact" class="texto" style="cursor: pointer">>> Dados de Contato do Aluno</span>
                                <div id="divAlunoContact" class="divData">
                                    <span>#{studentPhone1}: Telefone 1 do aluno</span>
                                    <br />
                                    <span>#{studentPhone2}: Telefone 2 do aluno</span>
                                    <br />
                                    <span>#{studentEmail}: Email do aluno</span>
                                </div>
                            </div>
                            <div class="divContent">
                                <span id="alunoAcademic" class="texto" style="cursor: pointer">>> Dados Acadêmicos do Aluno</span>
                                <div id="divAlunoAcademic" class="divData">
                                    <span>#{studentCourseCode}: Código do Curso do aluno</span>
                                    <br />
                                    <span>#{studentCourseName}: Nome do Curso do aluno</span>
                                    <br />
                                    <span>#{studentPeriod}: Periodo de Ingresso do aluno</span>
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="formulario formee">
                        <form id="form" action="<?= $uri ?>UPDATE" method="POST">
                            <div class="grid-10-12">
                                <label>Nome<em class="formee-req">*</em></label>
                                <input id="nome" name="nome" class="validate[required] text-input" type="text" value="<? echo $data['dados']['name']; ?>" />
                            </div>
                            <div class="grid-12-12">
                                <label>Título<em class="formee-req">*</em></label>
                                <input id="titulo" name="titulo" class="validate[required] text-input" type="text" value="<? echo $data['dados']['titulo']; ?>" />
                            </div>
                            <div class="grid-12-12">
                                <div class="grid-2-12" style="margin-left: -4px">
                                    <label>Status<em class="formee-req">*</em></label>
                                    <select id="status" name="status">
                                        <option value="1" <? echo $classFunction->validateSelect($data['dados']['status'], "1"); ?>>Ativo</option>
                                        <option value="0" <? echo $classFunction->validateSelect($data['dados']['status'], "0"); ?>>Inativo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-12-12">
                                <label>Conteúdo:</label>
                                <textarea id="textAreaValue" name="value" style="height: 600px"><? echo $data['dados']['value']; ?></textarea>
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
