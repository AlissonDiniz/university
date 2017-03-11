<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="aviso">
    <h1>
        <img alt="" src="<?= image ?>icons/star.png" />
        Página Principal
    </h1>
    <div class="conteudo">
        <div style="margin-bottom: 15px">
            <span style="padding: 10px">Período em Atividade - <strong><? echo $data['periodo']['codigo']; ?></strong></span>
            <h5></h5>
        </div>
        <div style="margin-bottom: 15px">
            <span style="padding: 10px">Quantidade de Disciplinas - <strong><? echo $data['disciplinas']; ?></strong></span>
            <h5></h5>
        </div>
        <div style="margin-bottom: 15px">
            <span style="padding: 10px">Hoje - <strong><? echo $data['hojeDescricao']; ?></strong></span>
            <br />
            <br />
            <span style="padding: 10px">Horários:</span>
            <ul style="margin: 15px 0 15px 40px">
                <?
                foreach ($data['horarios'] as $horario) {
                    ?>
                    <li style="text-align: left"><? echo $horario['dados']['nome']; ?><br /><? echo $horario['dados']['inicio']." - ".$horario['dados']['termino']; ?></li>
                    <?
                }
                ?>
            </ul>
            <h5></h5>
        </div>
    </div>

</div>
<div id="estatistica">
    <h1>
        <img alt="" src="<?= image ?>icons/message.png" />
        Mensagens
    </h1>
    <div class="conteudo">
        <?
        for ($index = 0; $index < count($data['mensagens']); $index++) {
            ?>
            <div>
                <span style="text-align: left; padding-left: 0">
                    <a style="color: #333333; text-decoration: none" href="<?= application ?>mensagem/show/<? echo $data['mensagens'][$index]['dados']['id']; ?>" style="text-decoration: none">
                        <?
                        if ($data['mensagens'][$index]['dados']['status'] != "1") {
                            echo "<strong>" . substr(str_replace("\r\n", "<br />", $data['mensagens'][$index]['dados']['conteudo']), 0, 50) . "...</strong>";
                        } else {
                            echo substr(str_replace("\r\n", "<br />", $data['mensagens'][$index]['dados']['conteudo']), 0, 50) . "...";
                        }
                        ?>
                    </a>
                </span>
                <h5></h5>
            </div>
            <?
        }
        ?>
    </div>
</div>