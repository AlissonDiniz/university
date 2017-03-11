<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Enum
 *
 * @author Alisson
 */
class Enum {

    public function enumStatus($value) {
        switch ($value) {
            case "1":
                echo "Ativo";
                break;
            default :
                echo "Inativo";
        }
    }

    public function enumAtividades($value) {
        switch ($value) {
            case "T":
                echo "Realizada";
                break;
            default :
                echo "Pendente";
        }
    }

    public function enumSimNao($value) {
        switch ($value) {
            case "1":
                echo "Sim";
                break;
            default :
                echo "Não";
        }
    }

    public function enumObrigatorio($value) {
        switch ($value) {
            case "1":
                echo "Obrigatória";
                break;
            default :
                echo "Optativa";
        }
    }

    public function enumSexo($value) {
        switch ($value) {
            case "F":
                echo "Feminino";
                break;
            default :
                echo "Masculino";
        }
    }

    public function enumCanhoto($value) {
        switch ($value) {
            case "S":
                echo "Canhoto";
                break;
            default :
                echo "Destro";
        }
    }

    public function enumTipoPendencia($value) {
        switch ($value) {
            case "1":
                echo "Bloqueia";
                break;
            default :
                echo "Não Bloqueia";
        }
    }

    public function enumTipoEtapa($value) {
        switch ($value) {
            case "F":
                echo "Nota Final";
                break;
            case "R":
                echo "Reposição";
                break;
            default :
                echo $value . "ª Unidade";
        }
    }

    public function enumOpcoes($value, $array) {
        foreach ($array as $line) {
            if ($value == $line['value']) {
                return $line['nome'];
                break;
            }
        }
    }

    public function enumMotivo($idOcorrencia, $idMotivo) {
        if ($idOcorrencia == "03" || $idOcorrencia == "26" || $idOcorrencia == "30") {
            $msg = "";
            for ($i = 0; $i < 10; $i++) {
                if ($i == "0" || $i == "2" || $i == "4" || $i == "6" || $i == "8") {
                    $motivo = substr($idMotivo, $i, 2);
                    switch ($motivo) {
                        case "01":
                            $msg = $msg . " - " . "código do banco invalido";
                            break;
                        case "02":
                            $msg = $msg . " - " . "código do registro detalhe inválido";
                            break;
                        case "03":
                            $msg = $msg . " - " . "código do segmento invalido";
                            break;
                        case "04":
                            $msg = $msg . " - " . "código do movimento não permitido para carteira";
                            break;
                        case "05":
                            $msg = $msg . " - " . "código de movimento invalido";
                            break;
                        case "06":
                            $msg = $msg . " - " . "tipo/numero de inscrição do cedente inválidos";
                            break;
                        case "07":
                            $msg = $msg . " - " . "agencia/conta/DV invalido";
                            break;
                        case "08":
                            $msg = $msg . " - " . "nosso numero invalido";
                            break;
                        case "09":
                            $msg = $msg . " - " . "nosso numero duplicado";
                            break;
                        case "10":
                            $msg = $msg . " - " . "carteira invalida";
                            break;
                        case "11":
                            $msg = $msg . " - " . "forma de cadastramento do titulo invalida Se desconto, titulo rejeitado - operação de desconto / horário limite.";
                            break;
                        case "12":
                            $msg = $msg . " - " . "tipo de documento invalido";
                            break;
                        case "13":
                            $msg = $msg . " - " . "identificação da emissão do bloqueto invalida";
                            break;
                        case "14":
                            $msg = $msg . " - " . "identificação da distribuição do bloqueto invalida";
                            break;
                        case "15":
                            $msg = $msg . " - " . "características da cobrança incompatíveis";
                            break;
                        case "16":
                            $msg = $msg . " - " . "data de vencimento invalida";
                            break;
                        case "17":
                            $msg = $msg . " - " . "data de vencimento anterior a data de emissão";
                            break;
                        case "18":
                            $msg = $msg . " - " . "vencimento fora do prazo de operação";
                            break;
                        case "19":
                            $msg = $msg . " - " . "titulo a cargo de bancos correspondentes com vencimento inferior a xx dias";
                            break;
                        case "20":
                            $msg = $msg . " - " . "valor do título invalido";
                            break;
                        case "21":
                            $msg = $msg . " - " . "espécie do titulo invalida";
                            break;
                        case "22":
                            $msg = $msg . " - " . "espécie não permitida para a carteira";
                            break;
                        case "23":
                            $msg = $msg . " - " . "aceite invalido";
                            break;
                        case "24":
                            $msg = $msg . " - " . "Data de emissão inválida";
                            break;
                        case "25":
                            $msg = $msg . " - " . "Data de emissão posterior a data de entrada";
                            break;
                        case "26":
                            $msg = $msg . " - " . "Código de juros de mora inválido";
                            break;
                        case "27":
                            $msg = $msg . " - " . "Valor/Taxa de juros de mora inválido";
                            break;
                        case "28":
                            $msg = $msg . " - " . "Código de desconto inválido";
                            break;
                        case "29":
                            $msg = $msg . " - " . "Valor do desconto maior ou igual ao valor do título";
                            break;
                        case "30":
                            $msg = $msg . " - " . "Desconto a conceder não confere";
                            break;
                        case "31":
                            $msg = $msg . " - " . "Concessão de desconto - já existe desconto anterior";
                            break;
                        case "32":
                            $msg = $msg . " - " . "Valor do IOF";
                            break;
                        case "33":
                            $msg = $msg . " - " . "Valor do abatimento inválido";
                            break;
                        case "34":
                            $msg = $msg . " - " . "Valor do abatimento maior ou igual ao valor do título";
                            break;
                        case "35":
                            $msg = $msg . " - " . "Abatimento a conceder não confere";
                            break;
                        case "36":
                            $msg = $msg . " - " . "Concessão de abatimento - já existe abatimento anterior";
                            break;
                        case "37":
                            $msg = $msg . " - " . "Código para protesto inválido";
                            break;
                        case "38":
                            $msg = $msg . " - " . "Prazo para protesto inválido";
                            break;
                        case "39":
                            $msg = $msg . " - " . "Pedido de protesto não permitido para o título";
                            break;
                        case "40":
                            $msg = $msg . " - " . "Título com ordem de protesto emitida";
                            break;
                        case "41":
                            $msg = $msg . " - " . "Pedido de cancelamento/sustação para títulos sem instrução de protesto";
                            break;
                        case "42":
                            $msg = $msg . " - " . "Código para baixa/devolução inválido";
                            break;
                        case "43":
                            $msg = $msg . " - " . "Prazo para baixa/devolução inválido";
                            break;
                        case "44":
                            $msg = $msg . " - " . "Código de moeda inválido";
                            break;
                        case "45":
                            $msg = $msg . " - " . "Nome do sacados não informado";
                            break;
                        case "46":
                            $msg = $msg . " - " . "Tipo /Número de inscrição do sacado inválidos";
                            break;
                        case "47":
                            $msg = $msg . " - " . "Endereço do sacado não informado";
                            break;
                        case "48":
                            $msg = $msg . " - " . "CEP inválido";
                            break;
                        case "49":
                            $msg = $msg . " - " . "CEP sem praça de cobrança (não localizado)";
                            break;
                        case "50":
                            $msg = $msg . " - " . "CEP referente a um Banco Correspondente";
                            break;
                        case "51":
                            $msg = $msg . " - " . "CEP incompatível com a unidade de federação";
                            break;
                        case "52":
                            $msg = $msg . " - " . "Unidade de federação inválida";
                            break;
                        case "53":
                            $msg = $msg . " - " . "Tipo/Número de inscrição do sacador/avalista inválidos";
                            break;
                        case "54":
                            $msg = $msg . " - " . "Sacador/Avalista não informado";
                            break;
                        case "55":
                            $msg = $msg . " - " . "Nosso número no Banco Correspondente não informado";
                            break;
                        case "56":
                            $msg = $msg . " - " . "Código do Banco Correspondente não informado";
                            break;
                        case "57":
                            $msg = $msg . " - " . "Código da multa inválido";
                            break;
                        case "58":
                            $msg = $msg . " - " . "Data da multa inválida";
                            break;
                        case "59":
                            $msg = $msg . " - " . "Valor/Percentual da multa inválido";
                            break;
                        case "60":
                            $msg = $msg . " - " . "Movimento para título não cadastrado";
                            break;
                        case "61":
                            $msg = $msg . " - " . "Alteração de agência cobradora/dv inválida";
                            break;
                        case "62":
                            $msg = $msg . " - " . "Tipo de impressão inválido";
                            break;
                        case "63":
                            $msg = $msg . " - " . "Entrada para título já cadastrado";
                            break;
                        case "64":
                            $msg = $msg . " - " . "Número da linha inválido";
                            break;
                    }
                }
            }
            return $msg;
        } else {
            $msg = "";
            for ($i = 0; $i < 10; $i++) {
                if ($i == "0" || $i == "2" || $i == "4" || $i == "6" || $i == "8") {
                    $motivo = substr($idMotivo, $i, 2);
                    switch ($motivo) {
                        case "01":
                            $msg = $msg . " - " . "Liquidação Por saldo";
                            break;
                        case "02":
                            $msg = $msg . " - " . "Liquidação Por conta";
                            break;
                        case "03":
                            $msg = $msg . " - " . "Liquidação No próprio banco";
                            break;
                        case "04":
                            $msg = $msg . " - " . "Liquidação Compensação eletrônica";
                            break;
                        case "05":
                            $msg = $msg . " - " . "Liquidação Compensação convencional";
                            break;
                        case "06":
                            $msg = $msg . " - " . "Liquidação Arquivo magnético";
                            break;
                        case "07":
                            $msg = $msg . " - " . "Liquidação Após feriado local";
                            break;
                        case "08":
                            $msg = $msg . " - " . "Liquidação Em cartório";
                            break;
                        case "09":
                            $msg = $msg . " - " . "Baixa Comandada banco";
                            break;
                        case "10":
                            $msg = $msg . " - " . "Baixa Comandada cliente arquivo";
                            break;
                        case "11":
                            $msg = $msg . " - " . "Baixa Comandada cliente on-line";
                            break;
                        case "12":
                            $msg = $msg . " - " . "Baixa Decurso prazo - cliente";
                            break;
                        case "13":
                            $msg = $msg . " - " . "Baixa Decurso prazo - banco";
                            break;
                    }
                }
            }
            return $msg;
        }
    }

}
?>