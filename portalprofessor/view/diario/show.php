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
                    <h1>Mostrar Diário da Disciplina</h1>
                    <h1>
                        <img src="<?= image ?>icons/diario.png" width="20" style="margin-right: 6px" />
                        Diários / Aulas</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= application ?>diario/listAula/<? echo $data['dados']['id']; ?>" >
                                <img src="<?= image ?>icons/aula.png" />
                                <span>Aulas</span>
                            </a> 
                            <a href="<?= application ?>diario/horarios/?d=<? echo $data['dados']['id']; ?>" >
                                <img src="<?= image ?>icons/date.png" />
                                <span>Horários</span>
                            </a>
                            <a href="<?= $uri ?>alunosMatriculados/<? echo $data['dados']['id']; ?>">
                                <img src="<?= image ?>icons/group.png" />
                                <span>Alunos Matriculados</span>
                            </a>
                        </p>
                    </div>
                    <?php
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee">
                        <label>
                            <span class="legenda">Disciplina:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['codDisciplina'] . " - " . $data['dados']['disciplina']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Período:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['periodo']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Inicio:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['data']->dataUSAToDataBrasil($data['dados']['inicio']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Término:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['data']->dataUSAToDataBrasil($data['dados']['inicio']); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Fórmula:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumOpcoes($data['dados']['formula'], $classFunction['formula']->loadOpcoes()); ?></span>
                        </label>
                        <label>
                            <span class="legenda">Vagas:</span>
                            <br />
                            <span class="texto"><? echo $data['dados']['vagas']; ?></span>
                        </label>
                        <label>
                            <span class="legenda">Status:</span>
                            <br />
                            <span class="texto"><? echo $classFunction['enum']->enumStatus($data['dados']['status']); ?></span>
                        </label>
                    </div>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
    </body>
</html>
