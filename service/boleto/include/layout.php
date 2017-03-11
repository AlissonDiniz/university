<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    <head>
        <?
        include_once 'css.php';
        ?>
    </head>
    <body>
        <div id="instrucoes">
            <ul>
                <li>Corte na linha indicada. N&aacute;o rasure, risque, fure ou dobre a regi&atilde;o onde se encontra o c&oacute;digo de barras.</li>
                <li>Caso n&atilde;o apare&ccedil;a o c&oacute;digo de barras no final, clique em F5 para atualizar esta tela.</li>
                <li>Caso tenha problemas ao imprimir, copie a sequencia num&eacute;rica abaixo e pague no caixa eletr&ocirc;nico ou no internet banking:</li>
            </ul>
        </div>
        <div id="cabecalho">
            <table cellspacing="0">
                <tr>
                    <td style="width: 200px">
                        <img alt="" src="<?= imageHttp ?>boleto/logo-empresa.png" />
                    </td>
                    <td>
                        <p>
                            <?php echo $data['dadosBoleto']["identificacao"]; ?>
                            <br />
                            <?php echo $data['dadosBoleto']["cpf_cnpj"]; ?>
                            <br />
                            <?php echo $data['dadosBoleto']["endereco"]; ?>
                            <br />
                            <?php echo $data['dadosBoleto']["cidade_uf"]; ?>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div id="viaSacado">
            <table cellspacing="0">
                <tr>
                    <td>
                        <img alt="" src="<?= imageHttp ?>boleto/logo-banco.png" />
                    </td>
                    <td style="font-size: 18px">
                        <?php echo $data['dadosBoleto']["codigo_banco_com_dv"] ?>
                    </td>
                    <td style="width: 500px; text-align: right; border-right: none; font-size: 16px">
                        <?php echo $data['dadosBoleto']["linha_digitavel"] ?>  
                    </td>
                </tr>
            </table>
            <table cellspacing="0">
                <tr>
                    <td style="width: 300px">
                        <div class="legenda">Cedente</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["cedente"]; ?></div>
                    </td>
                    <td style="width: 92px">
                        <div class="legenda">Ag&ecirc;ncia / C&oacute;digo do Cedente</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["ponto_venda"] . "&nbsp;&nbsp;&nbsp;" . $data['dadosBoleto']["codigo_cliente"]; ?></div>
                    </td>
                    <td style="width: 18px">
                        <div class="legenda">Esp&eacute;cie</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["especie"]; ?></div>
                    </td>
                    <td style="width: 30px">
                        <div class="legenda">Quantidade</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["quantidade"]; ?>&nbsp;</div>
                    </td>
                    <td style="width: 104px; border-right: none">
                        <div class="legenda">Nosso N&uacute;mero</div>
                        <div class="texto" style="text-align: right"><?php echo $data['dadosBoleto']["nosso_numero"]; ?></div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0">
                <tr>
                    <td style="width: 156px">
                        <div class="legenda">N&uacute;mero do Documento</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["numero_documento"]; ?></div>
                    </td>
                    <td style="width: 144px">
                        <div class="legenda">CPF/CNPJ</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["cpf_cnpj"]; ?></div>
                    </td>
                    <td style="width: 110px">
                        <div class="legenda">Vencimento</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["data_vencimento"]; ?></div>
                    </td>
                    <td style="width: 165px; border-right: none">
                        <div class="legenda">Valor do Documento</div>
                        <div class="texto" style="text-align: right"><?php echo $data['dadosBoleto']["valor_boleto"]; ?></div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0">
                <tr>
                    <td style="width: 100px">
                        <div class="legenda">(-) Desconto / Abatimento</div>
                        <div class="texto">&nbsp;<? echo $data['dadosBoleto']["valor_desconto"]; ?></div>
                    </td>
                    <td style="width: 85px">
                        <div class="legenda">(-) Outras Dedu&ccedil;&otilde;es</div>
                        <div class="texto">&nbsp;</div>
                    </td>
                    <td style="width: 85px">
                        <div class="legenda">(+) Mora / Multa</div>
                        <div class="texto">&nbsp;</div>
                    </td>
                    <td style="width: 110px">
                        <div class="legenda">(+) Outros Acr&eacute;scimos</div>
                        <div class="texto">&nbsp;</div>
                    </td>

                    <td style="width: 165px; border-right: none">
                        <div class="legenda">(=) Valor Cobrado</div>
                        <div class="texto" style="text-align: right">&nbsp;</div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0">
                <tr>
                    <td style="width: 400px; border-right: none">
                        <div class="legenda">Sacado</div>
                        <div class="texto">
                            <span style="text-transform: uppercase">
                                <?php echo $data['dadosBoleto']["sacado"]; ?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $data['dadosBoleto']["cpf"]; ?>
                            </span>
                        </div>
                        <div class="legenda" style="margin-top: 5px">Sacador/Avalista</div>
                        <div class="texto">
                            <span style="text-transform: uppercase">
                                <?php echo $data['dadosBoleto']["avalista"]; ?>
                            </span>
                        </div>
                    </td>
                    <td style="width: 235px; border-right: none">
                        <div class="legenda" style="margin-top: 30px">Curso</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["curso"]; ?></div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0">
                <tr>
                    <td style="border: none">
                        <div class="texto">Mensagens / Instru&ccedil;&otilde;es</div>
                        <div class="legenda" style="line-height: 11px">
                            <? echo "Ap&oacute;s ".$data["dias_de_prazo_para_pagamento"]." dias &uacute;teis do vencimento, cobrar Multa de R$ ".$data["multa"]." e juros de R$ ".$data["juros"]." ao dia retoativo ao vencimento<br />"; ?>
                            <?php
                            foreach ($data['dadosBoleto']["mensagem"] as $value) {
                                echo $value['dados'] . "<br />";
                            }
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="linha" style="margin-top: 50px">
            <span style="margin-top: -40px">
                Autentica&ccedil;&atilde;o Mec&acirc;nica
            </span>
            <span>
                via sacado
            </span>    
        </div>
        <div id="viaCaixa">
            <table cellspacing="0">
                <tr>
                    <td>
                        <img alt="" src="<?= imageHttp ?>boleto/logo-banco.png" />
                    </td>
                    <td style="font-size: 18px">
                        <?php echo $data['dadosBoleto']["codigo_banco_com_dv"] ?>
                    </td>
                    <td style="width: 500px; text-align: right; border-right: none; font-size: 16px">
                        <?php echo $data['dadosBoleto']["linha_digitavel"] ?>  
                    </td>
                </tr>
            </table>
            <table cellspacing="0">
                <tr>
                    <td style="width: 485px">
                        <div class="legenda">Local de pagamento</div>
                        <div class="texto">Pag&atilde;vel em qualquer Banco at&eacute; o vencimento</div>
                    </td>
                    <td style="width: 150px; border-right: none">
                        <div class="legenda">Vencimento</div>
                        <div class="texto" style="text-align: right"><?php echo $data['dadosBoleto']["data_vencimento"]; ?></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 485px">
                        <div class="legenda">Cedente</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["cedente"]; ?></div>
                    </td>
                    <td style="width: 150px; border-right: none">
                        <div class="legenda">Ponto Venda / Identifica&ccedil;&atilde;o do Cedente</div>
                        <div class="texto" style="text-align: right"><?php echo $data['dadosBoleto']["ponto_venda"] . "&nbsp;&nbsp;&nbsp;" . $data['dadosBoleto']["codigo_cliente"]; ?></div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0">
                <tr>
                    <td style="width: 82px">
                        <div class="legenda">Data do Documento</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["data_documento"]; ?></div>
                    </td>
                    <td style="width: 128px">
                        <div class="legenda">N&uacute;mero do Documento</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["numero_documento"]; ?></div>
                    </td>
                    <td style="width: 45px">
                        <div class="legenda">Esp&eacute;cie doc.</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["especie_doc"]; ?></div>
                    </td>
                    <td style="width: 15px">
                        <div class="legenda">Aceite</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["aceite"]; ?></div>
                    </td>
                    <td style="width: 95px">
                        <div class="legenda">Data do processamento</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["data_processamento"]; ?></div>
                    </td>
                    <td style="width: 150px; border-right: none">
                        <div class="legenda">Nosso N&uacute;mero</div>
                        <div class="texto" style="text-align: right"><?php echo $data['dadosBoleto']["nosso_numero"]; ?></div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0">
                <tr>
                    <td style="width: 211px">
                        <div class="legenda">Carteira</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["carteira_descricao"]; ?></div>
                    </td>
                    <td style="width: 30px">
                        <div class="legenda">Esp&eacute;cie</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["especie"]; ?></div>
                    </td>
                    <td style="width: 59px">
                        <div class="legenda">Quantidade</div>
                        <div class="texto">&nbsp;</div>
                    </td>
                    <td style="width: 95px">
                        <div class="legenda">(x) Valor</div>
                        <div class="texto">&nbsp;</div>
                    </td>
                    <td style="width: 150px; border-right: none">
                        <div class="legenda">(=) Valor do Documento</div>
                        <div class="texto" style="text-align: right"><?php echo $data['dadosBoleto']["valor_boleto"]; ?></div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0">
                <tr>
                    <td style="width: 485px">
                        <div class="texto" style="margin-top: -75px">Mensagens / Instru&ccedil;&otilde;es</div>
                        <div class="legenda" style="line-height: 11px">
                            <? echo "Ap&oacute;s ".$data["dias_de_prazo_para_pagamento"]." dias &uacute;teis do vencimento, cobrar Multa de R$ ".$data["multa"]." e juros de R$ ".$data["juros"]." ao dia retoativo ao vencimento<br />"; ?>
                            <?php
                            foreach ($data['dadosBoleto']["mensagem"] as $value) {
                                echo $value['dados'] . "<br />";
                            }
                            ?>
                        </div>
                    </td>
                    <td style="width: 150px; border-right: none">
                        <div>
                            <div class="legenda">(-) Desconto / Abatimento</div>
                            <div class="texto" style="text-align: right">&nbsp;<? echo $data['dadosBoleto']["valor_desconto"]; ?></div>
                        </div>
                        <div style="margin: 0 -6px 0 -7px; width: 154px; padding: 0 6px 0 6px; border-top: solid 1px #000">
                            <div class="legenda">(-) Outras Dedu&ccedil;&otilde;es</div>
                            <div class="texto" style="text-align: right">&nbsp;</div>
                        </div>
                        <div style="margin: 0 -6px 0 -7px; width: 154px; padding: 0 6px 0 6px; border-top: solid 1px #000">
                            <div class="legenda">(+) Mora / Multa</div>
                            <div class="texto" style="text-align: right">&nbsp;</div>
                        </div>
                        <div style="margin: 0 -6px 0 -7px; width: 154px; padding: 0 6px 0 6px; border-top: solid 1px #000">
                            <div class="legenda">(+) Outros Acr&eacute;scimos</div>
                            <div class="texto" style="text-align: right">&nbsp;</div>
                        </div>
                        <div style="margin: 0 -6px 0 -7px; width: 154px; padding: 0 6px 0 6px; border-top: solid 1px #000">
                            <div class="legenda">(=) Valor cobrado</div>
                            <div class="texto" style="text-align: right">&nbsp;</div>
                        </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0">
                <tr>
                    <td style="width: 400px; border-right: none">
                        <div class="legenda">Sacado</div>
                        <div class="texto">
                            <span style="text-transform: uppercase">
                                <?php echo $data['dadosBoleto']["sacado"]; ?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $data['dadosBoleto']["cpf"]; ?>
                            </span>
                            <br />
                            <span style="font-weight: normal; margin: 5px 0 0 2px;">
                                <?php echo $data['dadosBoleto']["endereco1"]; ?>
                            </span>
                            <br />
                            <span style="font-weight: normal; margin: 5px 0 0 2px;">
                                <?php echo $data['dadosBoleto']["endereco2"]; ?>
                            </span>
                        </div>
                        <div class="legenda" style="margin-top: 5px">Sacador/Avalista</div>
                        <div class="texto">
                            <span style="text-transform: uppercase">
                                <?php echo $data['dadosBoleto']["avalista"]; ?>
                            </span>
                        </div>
                    </td>
                    <td style="width: 235px; border-right: none">
                        <div class="legenda" style="margin-top: -45px">Curso</div>
                        <div class="texto"><?php echo $data['dadosBoleto']["curso"]; ?></div>
                    </td>
                </tr>
            </table>
            <div id="codigoBarras">
                <img src="<?= serviceHttp ?>boleto/barcode?code=<?php echo $data['dadosBoleto']["codigo_barras"]; ?>" />
                <span style="font-size: 10px; margin: -45px 0 0 80px">
                    Autentica&ccedil;&atilde;o Mec&acirc;nica
                </span>
            </div>
        </div>
    </body>
</html>