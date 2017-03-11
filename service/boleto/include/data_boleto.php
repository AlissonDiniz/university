<?php

$codigobanco = $data['dadosBoleto']['banco'];
$codigo_banco_com_dv = geraCodigoBanco($codigobanco);
$nummoeda = "9";
$fixo = "9";
$ios = "0";
$fator_vencimento = fator_vencimento($data['dadosBoleto']["data_vencimento"]);
$valor = formata_numero($data['dadosBoleto']["valor_boleto"], 10, 0, "valor");
$carteira = $data['dadosBoleto']["carteira"];
$codigocliente = formata_numero($data['dadosBoleto']["codigo_cliente"], 7, 0);
$nossonumero = formata_numero($data['dadosBoleto']["nosso_numero"], 13, 0);
$barra = "$codigobanco$nummoeda$fator_vencimento$valor$fixo$codigocliente$nossonumero$ios$carteira";
$dv = digitoVerificador_barra($barra);
$linha = substr($barra, 0, 4) . $dv . substr($barra, 4);

$data['dadosBoleto']["codigo_barras"] = $linha;
$data['dadosBoleto']["linha_digitavel"] = monta_linha_digitavel($linha);
$data['dadosBoleto']["nosso_numero"] = $nossonumero;
$data['dadosBoleto']["codigo_banco_com_dv"] = $codigo_banco_com_dv;

?>