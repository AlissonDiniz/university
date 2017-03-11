<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= css ?>main.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-style.css" />
        <link rel="stylesheet" type="text/css" href="<?= plugin ?>formee-3-1/css/formee-structure.css" />
        <link rel="stylesheet" type="text/css" href="<?= css . "show.css" ?>" />
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
                    <h1>Listar Parcelas</h1>
                    <div class="submenus">
                        <p>
                            <a href="<?= application ?>plano/show/<? echo $data['plano']['id']; ?>">
                                <img src="<?= image ?>icons/arrow_left.png" />
                                <span>Voltar</span>
                            </a>
                            <a href="<?= $uri; ?>create?plano=<? echo $data['plano']['id']; ?>">
                                <img src="<?= image ?>icons/database_add.png" />
                                <span>Cadastrar</span>
                            </a>
                        </p>
                    </div>
                    <?
                    include_once '../view/layout/main.php';
                    ?>
                    <div class="conteudo formee" style="margin-bottom: 20px">
                        <label style="width: 60px">
                            <span class="legenda">Período:</span>
                            <br />
                            <span class="texto"><? echo $data['plano']['periodo']; ?></span>
                        </label>
                        <label style="width: 350px">
                            <span class="legenda">Curso:</span>
                            <br />
                            <span class="texto"><? echo substr($data['plano']['curso'], 0, 40); ?>...</span>
                        </label>
                        <label style="width: 280px">
                            <span class="legenda">Descrição:</span>
                            <br />
                            <span class="texto"><? echo $data['plano']['descricao']; ?></span>
                        </label>
                    </div>
                    <div>
                        <table id="mytable" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <td width="120" colspan="2">Parcela</td>
                                    <td width="130">Mês</td>
                                    <td width="150">Valor</td>
                                    <td width="150">Vencimento</td>
                                    <td width="150" style="border-right: none">Observação</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $linha = 0;
                                foreach ($data['parcelas'] as $line) {
                                    if ($linha == 0) {
                                        $linha = 1;
                                        ?>
                                        <tr>
                                            <td width="20">
                                                <a href="<?= $uri ?>show/<?php echo $line['dados']['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </td>
                                            <td width="100"><?php echo $line['dados']['numero']; ?></td>
                                            <td width="130"><?php echo $classFunction["enum"]->enumOpcoes($line['dados']['mes'], $classFunction["meses"]->loadOpcoes()); ?></td>
                                            <td width="150"><?php echo $classFunction["number"]->formatMoney($line['dados']['valor']); ?></td>
                                            <td width="150"><?php echo $classFunction["data"]->dataUSAToDataBrasil($line['dados']['data_vencimento']); ?></td>
                                            <td width="150" style="border-right: none"><?php echo $line['dados']['observacao']; ?></td>
                                        </tr>

                                        <?php
                                    } else {

                                        $linha = 0;
                                        ?>
                                       <tr>
                                            <th width="20">
                                                <a href="<?= $uri ?>show/<?php echo $line['dados']['id']; ?>">
                                                    <img alt="" src="<?= image ?>icons/zoom.png" />
                                                </a>
                                            </th>
                                            <th width="100"><?php echo $line['dados']['numero']; ?></th>
                                            <th width="130"><?php echo $classFunction["enum"]->enumOpcoes($line['dados']['mes'], $classFunction["meses"]->loadOpcoes()); ?></th>
                                            <th width="150"><?php echo $classFunction["number"]->formatMoney($line['dados']['valor']); ?></th>
                                            <th width="150"><?php echo $classFunction["data"]->dataUSAToDataBrasil($line['dados']['data_vencimento']); ?></th>
                                            <th width="150" style="border-right: none"><?php echo $line['dados']['observacao']; ?></th>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                include_once '../view/layout/footer.php';
                ?>
            </div>
        </div>
    </body>
</html>
