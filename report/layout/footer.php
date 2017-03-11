<div class="rodape">
    <div class="usuario">
        <h4>
            Usuário
            <br />
            <span style="float: left; color: #000000; padding-left: 5px;  font-size: 10px">
                <? echo $_SESSION['nome']; ?>
            </span>
        </h4>
    </div>
    <p class="p">
        Campina Grande,
        <?
        setlocale(LC_ALL, "ptb");
        echo strftime('%d') . " de " . strftime('%B') . " de " . strftime('%Y');
        ?>
        <br />
        <br />
        <img class="img2"
             src="<?= image ?>proprio/imprimir.gif"
             alt="Imprimir"
             onClick="javascript:window.print();"
             width="30"
             height="30" />
    </p>
</div>

