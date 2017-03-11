<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . $method . ".css" ?>" />
        <link rel="stylesheet" type="text/css" href="<?= css . "aluno/show.css" ?>" />
        <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
        <script type="text/javascript" src="<?= plugin ?>formee-3-1/js/formee.js"></script>
        <script type="text/javascript" src="<?= js ?>accordion.js" ></script>
        <link rel="shortcut icon" href="<?= image ?>logos/favico.png" />
        <title><?= name ?></title>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#historicoButton").click(function() {
                    $("#historicoForm").submit();
                });
                $("#editButton").click(function() {
                    $("#editForm").submit();
                });
                $("#pendenciaButton").click(function() {
                    $("#pendenciaForm").submit();
                });
                $("#matriculasButton").click(function() {
                    $("#formMatriculas").submit();
                });
                $("#financeiroButton").click(function() {
                    $("#formFinenceiro").submit();
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
                    <h1>Mostrar Aluno</h1>
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
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee">
                        <label>
                            <a title="Mostrar o Cadastro da pessoa" href="<?= application ?>pessoa/show/<? echo $data['dados']['pessoa_id']; ?>" target="_blank">
                                <img alt="" src="<?= profile . "?id=" . base64_encode($data['dados']['cpf']) ?>" width="100" height="120" style="border: none" />
                            </a>
                        </label>
                        <div class="submenus">
                            <p style="margin-left: 5px">
                                <a title="Histórico do Aluno" id="historicoButton" href="#">
                                    <img src="<?= image ?>icons/report.png" />
                                    <span>Histórico</span>
                                </a>
                                <a title="Períodos Matriculados do Aluno" id="matriculasButton" href="#">
                                    <img src="<?= image ?>icons/inbox.png" />
                                    <span>Matriculas</span>
                                </a>
                                <a title="Financeiro do Aluno" id="financeiroButton" href="#">
                                    <img src="<?= image ?>icons/money.png" />
                                    <span>Financeiro</span>
                                </a>
                                <a title="Pendências do Aluno" id="pendenciaButton" href="#">
                                    <img src="<?= image ?>icons/comments-red.png" />
                                    <span>Pendências</span>
                                </a>
                                <a style="margin: 0 20px 0 -5px" title="Atividades Complementares do Aluno" href="<?= $uri ?>atividade/<? echo $data['dados']['id']; ?>">
                                    <img src="<?= image ?>icons/complemento.png" />
                                    <span>Atividades</span>
                                    <br />
                                    <span style="font-size: 8px"> Complementares</span>
                                </a>
                                <a title="Enade do Aluno" id="enadeButton" href="#">
                                    <img src="<?= image ?>icons/medal.png" />
                                    <span>Enade</span>
                                </a>
                            </p>
                        </div>
                        <div class="alertas">
                            <? $classFunction['funcoesHTML']->createAlertas("P", $data['pendencias']); ?>
                            <? $classFunction['funcoesHTML']->createAlertas("O", $data['observacoes']); ?>
                        </div>
                        <label>
                            <span class="legenda">CPF:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['cpf']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Nome:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['nome']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Matricula:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['matricula']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Estrutura Curricular:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['grade']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Período Ingresso:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['periodoIngresso']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Forma de Ingresso:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['dados']['forma_ingresso'], $classFunction['formaIngresso']->loadOpcoes()); ?></span>
                        </label>
                        <label>
                            <span class="legenda">CPF/CNPJ do Responsável:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['cpfResponsavel']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Nome do Responsável:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['nomeResponsavel']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Módulo:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['modulo']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Turno:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['dados']['turno'], $classFunction['turnos']->loadOpcoes()); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Situação:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['dados']['situacao'], $classFunction['situacaoAluno']->loadOpcoes()); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Status:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumStatus($data['dados']['status']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Observa&ccedil;&atilde;o:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['observacao']; ?></span>
                        </label>
                        <div class="grid-4-12">
                            <input id="editButton" class="left" type="button" title="Editar a <?php echo $action; ?>" value="Editar" />
                        </div>
                        <form id="historicoForm" target="_blank" action="<?= $uri ?>resultReportHistorico" method="POST">
                            <input type="hidden" name="cpf" value="" />
                            <input type="hidden" name="matricula" value="<? echo $data['dados']['matricula']; ?>" />
                            <input type="hidden" name="tipo" value="Conferencia" />
                        </form>
                        <form id="editForm" action="<?= $uri ?>edit" method="POST">
                            <input type="hidden" name="id" value="<? echo $data['dados']['id']; ?>" />
                        </form>
                        <form id="pendenciaForm" action="<?= application ?>pendencia/result" method="POST">
                            <input type="hidden" name="cpf" value="<? echo $data['dados']['cpf']; ?>" />
                            <input type="hidden" name="nome" value="" />
                            <input type="hidden" name="origem" value="%" />
                            <input type="hidden" name="status" value="%" />
                            <input type="hidden" name="type" value="%" />
                        </form>
                        <form id="formMatriculas" action="<?= application ?>matricula/listAluno" method="POST">
                            <input type="hidden" name="aluno" value="<? echo $data['dados']['id']; ?>" />
                        </form>
                        <form id="formFinenceiro" action="<?= application ?>titulo/listByAluno" method="POST">
                            <input type="hidden" name="aluno" value="<? echo $data['dados']['id']; ?>" />
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
